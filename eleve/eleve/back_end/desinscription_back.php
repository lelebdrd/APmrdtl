<?php

session_start();

require('include/_inc_parametres.php');

require('include/_inc_connexion.php');

 

// Vérification que l'élève est connecté

if (!isset($_SESSION['connect']) || $_SESSION['connect'] !== true) {

    header('Location:../connexion.php');

    exit;

}

 

// Vérification que l'id_animation est bien passé en paramètre

if (!isset($_GET['id_animation']) || !is_numeric($_GET['id_animation'])) {

    header('Location:../front_end/mes_inscriptions.php');

    exit;

}

 

$id_animation = (int)$_GET['id_animation'];

 

// Récupérer l'id de l'élève connecté

$emel_chiffre = bin2hex(sodium_crypto_secretbox($_SESSION['id'], $nonce, $cle_secrete));

$req_id = $cnx->prepare("SELECT ID FROM inscrit WHERE emel_chiffr = :emel");

$req_id->bindValue(':emel', $emel_chiffre, PDO::PARAM_STR);

$req_id->execute();

$eleve = $req_id->fetch(PDO::FETCH_OBJ);

 

if (!$eleve) {

    header('Location:../connexion.php');

    exit;

}

 

// Vérifier que la désinscription est possible (au moins 1 semaine avant)

$req_date = $cnx->prepare("SELECT DateHeureDeb FROM animation WHERE ID = :id");

$req_date->bindValue(':id', $id_animation, PDO::PARAM_INT);

$req_date->execute();

$animation = $req_date->fetch(PDO::FETCH_OBJ);

 

if (!$animation) {

    header('Location:../front_end/mes_inscriptions.php');

    exit;

}

 

$date_animation = new DateTime($animation->DateHeureDeb);

$maintenant = new DateTime();

$diff = $maintenant->diff($date_animation);

$jours_restants = (int)$diff->format('%r%a');

 

if ($jours_restants < 7) {

    $_SESSION['erreur'] = "Désinscription impossible : l'animation a lieu dans moins d'une semaine.";

    header('Location:../front_end/mes_inscriptions.php');

    exit;

}

 

// Supprimer l'inscription

$req_del = $cnx->prepare("

    DELETE FROM inscription 

    WHERE id_inscrit = :id_inscrit 

    AND id_animation = :id_animation

");

$req_del->bindValue(':id_inscrit', $eleve->ID, PDO::PARAM_INT);

$req_del->bindValue(':id_animation', $id_animation, PDO::PARAM_INT);

$req_del->execute();

 

$_SESSION['succes'] = "Votre désinscription a bien été prise en compte.";

header('Location:../front_end/mes_inscriptions.php');

exit;

?>