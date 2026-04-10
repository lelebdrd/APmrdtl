<?php
session_start();

require('../back_end/include/_inc_parametres.php');
require('../back_end/include/_inc_connexion.php');

if (!isset($_SESSION['connect']) || $_SESSION['connect'] !== true) {
    header('Location:connexion.php');
    exit;
}

// Chiffre l'email stocké en session pour le comparer à la BDD
$emel_chiffre = bin2hex(sodium_crypto_secretbox($_SESSION['id'], $nonce, $cle_secrete));

$req_id = $cnx->prepare("SELECT ID FROM inscrit WHERE emel_chiffr = :emel");
$req_id->bindValue(':emel', $emel_chiffre, PDO::PARAM_STR);
$req_id->execute();
$eleve = $req_id->fetch(PDO::FETCH_OBJ);

// Récupère toutes les animations à venir non annulées
$req = $cnx->prepare("
    SELECT 
        animation.ID,
        animation.Titre,
        animation.DateHeureDeb,
        animation.DateHeureFin,
        animation.commentaire,
        animation.nbreMin,     
        animation.nbreMax,       
        animation.materiel,
        lieu.batiment,
        lieu.numsalle,
        theme.libelle AS theme,

        (SELECT COUNT(*) FROM inscription WHERE inscription.id_animation = animation.ID) AS nb_inscrits,
        (SELECT COUNT(*) FROM inscription WHERE inscription.id_animation = animation.ID AND inscription.id_inscrit = :id_inscrit) AS deja_inscrit

        FROM animation
        LEFT JOIN lieu ON animation.idLieu = lieu.ID
        LEFT JOIN theme ON animation.idTheme = theme.ID
        WHERE animation.annulation = 0 
            AND animation.DateHeureDeb > NOW()
        ORDER BY animation.DateHeureDeb ASC  
");
$req->bindValue(':id_inscrit', $eleve->ID, PDO::PARAM_INT);
$req->execute();
$animations = $req->fetchAll(PDO::FETCH_OBJ);
// Tableau 1 element = 1 animation avec infos
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css.css">
    <title>Animations</title>
</head>
<body>

<?php include('../include/entete.php'); ?>

<?php if (isset($_SESSION['erreur'])): ?>
    <p class="message-erreur"><?= htmlspecialchars($_SESSION['erreur']) ?></p>
    <?php unset($_SESSION['erreur']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['succes'])): ?>
    <p class="message-succes"><?= htmlspecialchars($_SESSION['succes']) ?></p>
    <?php unset($_SESSION['succes']); ?>
<?php endif; ?>

<main>
    <?php if (empty($animations)): ?>
        <p>Aucune animation à venir pour le moment.</p>

    <?php else: ?>
        <div class="grille-animations">
        <?php foreach ($animations as $animation): ?>

            <div class="carte">
                <h3><?= htmlspecialchars($animation->Titre) ?></h3>
                <p><?= htmlspecialchars($animation->commentaire) ?></p>

                <p>Lieu : <?= htmlspecialchars($animation->batiment) ?> - salle <?= htmlspecialchars($animation->numsalle) ?></p>

                <p>Thème : <?= htmlspecialchars($animation->theme) ?></p>
                <p>Matériel : <?= htmlspecialchars($animation->materiel) ?></p>

                <p>Inscrits : <?= $animation->nb_inscrits ?> / <?= $animation->nbreMax ?> (min : <?= $animation->nbreMin ?>)</p>

                <div class="carte-footer">
                    <span class="heure">
                        <?= date('d/m/Y', strtotime($animation->DateHeureDeb)) ?>
                        <?= date('H:i', strtotime($animation->DateHeureDeb)) ?> - <?= date('H:i', strtotime($animation->DateHeureFin)) ?>
                    </span>

                    <?php if ($animation->deja_inscrit > 0): ?>
                        <span class="inscrit">✓ Déjà inscrit</span>

                    <?php elseif ($animation->nb_inscrits >= $animation->nbreMax): ?>
                        <span class="complet">Complet</span>

                    <?php else: ?>
                        <a class="btn-inscrire"
                           href="../back_end/inscription_back.php?id_animation=<?= $animation->ID ?>"
                           onclick="return confirm('S\'inscrire à cette animation ?')">
                           S'inscrire
                        </a>
                    <?php endif; ?>

                </div>
            </div>

        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

</body>
</html>