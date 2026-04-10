<?php
session_start();

require('include/_inc_parametres.php');
require('include/_inc_connexion.php');
if (!isset($_SESSION['connect']) || $_SESSION['connect'] !== true) {
    header('Location:../connexion.php');
    exit;
}

if (!isset($_GET['id_animation']) || !is_numeric($_GET['id_animation'])) {
    header('Location:../front_end/animations.php');
    exit;
}

$id_animation = (int)$_GET['id_animation'];


$emel_chiffre = bin2hex(sodium_crypto_secretbox($_SESSION['id'], $nonce, $cle_secrete));

$req_id = $cnx->prepare("SELECT ID FROM inscrit WHERE emel_chiffr = :emel");
$req_id->bindValue(':emel', $emel_chiffre, PDO::PARAM_STR);
$req_id->execute();
$eleve = $req_id->fetch(PDO::FETCH_OBJ);

if (!$eleve) {
    header('Location:../connexion.php');
    exit;
}

$req_anim = $cnx->prepare("
    SELECT ID, DateHeureDeb, nbreMax
    FROM animation
    WHERE ID = :id
      AND annulation = 0        -- Exclut les animations annulées
      AND DateHeureDeb > NOW()  -- Exclut les animations passées
");
$req_anim->bindValue(':id', $id_animation, PDO::PARAM_INT);
$req_anim->execute();
$animation = $req_anim->fetch(PDO::FETCH_OBJ);

if (!$animation) {
    $_SESSION['erreur'] = "Cette animation n'existe pas ou n'est plus disponible.";
    header('Location:../front_end/animations.php');
    exit;
}

$req_deja = $cnx->prepare("
    SELECT COUNT(*) AS nb
    FROM inscription
    WHERE id_inscrit = :id_inscrit
      AND id_animation = :id_animation
");
$req_deja->bindValue(':id_inscrit', $eleve->ID, PDO::PARAM_INT);
$req_deja->bindValue(':id_animation', $id_animation, PDO::PARAM_INT);
$req_deja->execute();
$deja = $req_deja->fetch(PDO::FETCH_OBJ);

if ($deja->nb > 0) {
    $_SESSION['erreur'] = "Vous êtes déjà inscrit à cette animation.";
    header('Location:../front_end/animations.php');
    exit;
}

$req_nb = $cnx->prepare("
    SELECT COUNT(*) AS nb_inscrits
    FROM inscription
    WHERE id_animation = :id_animation
");
$req_nb->bindValue(':id_animation', $id_animation, PDO::PARAM_INT);
$req_nb->execute();
$nb = $req_nb->fetch(PDO::FETCH_OBJ);

// Compare le nombre d'inscrits au maximum autorisé
if ($nb->nb_inscrits >= $animation->nbreMax) {
    $_SESSION['erreur'] = "Cette animation est complète.";
    header('Location:../front_end/animations.php');
    exit;
}
$req_ins = $cnx->prepare("
    INSERT INTO inscription (id_inscrit, id_animation, presence)
    VALUES (:id_inscrit, :id_animation, 0)
");
$req_ins->bindValue(':id_inscrit', $eleve->ID, PDO::PARAM_INT);
$req_ins->bindValue(':id_animation', $id_animation, PDO::PARAM_INT);
$req_ins->execute();

$_SESSION['succes'] = "Votre inscription a bien été prise en compte.";
header('Location:../front_end/animations.php');
exit;
?>