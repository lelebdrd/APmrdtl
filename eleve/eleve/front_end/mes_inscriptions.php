<?php
session_start();

require('../back_end/include/_inc_parametres.php');
//crée $cnx
require('../back_end/include/_inc_connexion.php');

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['connect']) || $_SESSION['connect'] !== true) {
    header('Location:connexion.php');
    exit;
}

// Chiffrement de l'email. bin2hex() convertit le résultat
$emel_chiffre = bin2hex(
    sodium_crypto_secretbox($_SESSION['id'], $nonce, $cle_secrete)
);

// Recherche élève dans BDD grâce à email chiffré
$req_id = $cnx->prepare(
    "SELECT ID FROM inscrit WHERE emel_chiffr = :emel"
);
$req_id->bindValue(':emel', $emel_chiffre, PDO::PARAM_STR);
$req_id->execute();
$eleve = $req_id->fetch(PDO::FETCH_OBJ); // Récupère le résultat sous forme d'objet

// Si aucun élève trouvé page de connexion
if (!$eleve) {
    session_destroy();
    header('Location:connexion.php');
    exit;
}

// Récupère inscriptions élève avec détails animation
$req = $cnx->prepare("
    SELECT a.ID,
           a.Titre,
           a.DateHeureDeb,    -- Date et heure de début de l'animation
           a.DateHeureFin,    -- Date et heure de fin
           a.commentaire,     -- Description de l'animation
           i.presence         -- 1 = présent, 0 = absent
    FROM inscription i
    JOIN animation a ON i.id_animation = a.ID  -- Jointure pour récupérer les infos de l'animation
    WHERE i.id_inscrit = :id_inscrit
    ORDER BY a.DateHeureDeb DESC  -- Les plus récentes en premier
");
$req->bindValue(':id_inscrit', $eleve->ID, PDO::PARAM_INT);
$req->execute();
$inscriptions = $req->fetchAll(PDO::FETCH_OBJ); 
?>
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css.css">
    <title>Mes inscriptions</title>
</head>
<body>

<?php include(__DIR__ . '/../include/entete.php'); ?>
<main>

    <?php if (isset($_SESSION['erreur'])): ?>
        <div class="message-erreur">
            <?= htmlspecialchars($_SESSION['erreur']) ?>
            <!-- protection contre les failles XSS -->
        </div>
        <?php unset($_SESSION['erreur']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['succes'])): ?>
        <div class="message-succes">
            <?= htmlspecialchars($_SESSION['succes']) ?>
        </div>
        <?php unset($_SESSION['succes']); ?>
    <?php endif; ?>

    <?php if (empty($inscriptions)): ?>
        <p>Vous n'avez aucune inscription pour le moment.</p>

    <?php else: ?>
        <div class="grille-animations">
            <?php foreach ($inscriptions as $i):
                // Formate les heures
                $heure = date('d/m/Y H:i', strtotime($i->DateHeureDeb))
                       . ' - '
                       . date('H:i', strtotime($i->DateHeureFin));

                // Vérifie si l'animation est dans le futur
                $estFuture = strtotime($i->DateHeureDeb) > time();
            ?>
                <!-- Carte cliquable pour chaque inscription -->
                <div class="carte"
                     style="cursor:pointer"
                     id="carte-<?= $i->ID ?>"
                     data-titre="<?= htmlspecialchars($i->Titre, ENT_QUOTES) ?>"
                     data-commentaire="<?= htmlspecialchars($i->commentaire, ENT_QUOTES) ?>"
                     data-heure="<?= htmlspecialchars($heure, ENT_QUOTES) ?>"
                     data-presence="<?= $i->presence == 1 ? 'present' : ($estFuture ? 'futur' : 'absent') ?>"
                     data-id="<?= $i->ID ?>"
                     onclick="ouvrirModal(<?= $i->ID ?>)"> <!-- Appelle la fonction JS au clic -->

                    <h3><?= htmlspecialchars($i->Titre) ?></h3>
                    <p><?= htmlspecialchars($i->commentaire) ?></p>

                    <div class="carte-footer">
                        <span class="heure"><?= $heure ?></span>
                        <?php if ($i->presence == 1): ?>
                            <span class="inscrit">Présent</span>
                        <?php elseif ($estFuture): ?>
                            <span class="inscrit">À venir</span>
                        <?php else: ?>
                            <span class="complet">Absent</span>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<!-- Modale : cachée par défaut, s'affiche via la classe CSS "actif" -->
<div class="modal-overlay" id="modal-overlay" onclick="fermerModal(event)">
    <div class="modal">
        <h3 id="modal-titre"></h3>   
        <div class="modal-corps">
            <p id="modal-commentaire"></p>  
            <div class="modal-footer">
                <span class="heure" id="modal-heure"></span>      
                <span id="modal-presence"></span>                  
            </div>
            <div style="margin-top: 14px;">
                <span id="modal-bouton"></span> <!-- Bouton de désinscription -->
            </div>
        </div>
    </div>
</div>
 
<script>
// Ouvre la modale et la remplit avec les données de la carte cliquée
function ouvrirModal(id) {
    var carte = document.getElementById('carte-' + id);

    document.getElementById('modal-titre').textContent       = carte.dataset.titre;
    document.getElementById('modal-commentaire').textContent = carte.dataset.commentaire;
    document.getElementById('modal-heure').textContent       = carte.dataset.heure;

    if (carte.dataset.presence === 'present') {
        document.getElementById('modal-presence').innerHTML =
            '<span class="inscrit">Présent</span>';
    } else if (carte.dataset.presence === 'futur') {
        document.getElementById('modal-presence').innerHTML =
            '<span class="inscrit">À venir</span>';
    } else {
        document.getElementById('modal-presence').innerHTML =
            '<span class="complet">Absent</span>';
    }

    document.getElementById('modal-bouton').innerHTML =
        '<a href="../back_end/desinscription_back.php?id_animation=' + id + '" '
        + 'class="btn-desinscrire" '
        + 'onclick="return confirm(\'Se désinscrire de cette animation ?\')">'
        + 'Se désinscrire</a>';

    document.getElementById('modal-overlay').classList.add('actif');
}

// Ferme la modale si utilisateur clique sur fond
function fermerModal(event) {
    if (event.target === document.getElementById('modal-overlay')) {
        document.getElementById('modal-overlay').classList.remove('actif');
    }
}
</script>
 
</body>
</html>