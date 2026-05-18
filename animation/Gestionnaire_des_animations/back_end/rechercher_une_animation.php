<?php

// Vérification admin
if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
    exit;
}

require('../../back_end/include/config.php');

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    header('Location: ../front_end/erreur.php?type=animation');
    exit;
}

$id = intval($_GET['id']);

// 1️ Charger l'animation
$req_pre = $cnx->prepare("SELECT * FROM animation WHERE ID = :id");
$req_pre->bindValue(':id', $id, PDO::PARAM_INT);
$req_pre->execute();
$animation = $req_pre->fetch(PDO::FETCH_ASSOC);

if (!$animation) {
    header('Location: ../Gestionnaire_des_animations/front_end/erreur.php?type=animation');
    exit;
}

// 2️ Charger le thème associé
$req_theme = $cnx->prepare("SELECT * FROM theme WHERE ID = :idTheme");
$req_theme->bindValue(':idTheme', $animation['idTheme'], PDO::PARAM_INT);
$req_theme->execute();
$theme = $req_theme->fetch(PDO::FETCH_ASSOC);

// 3️ Charger le lieu associé
$req_lieu = $cnx->prepare("SELECT * FROM lieu WHERE ID = :idLieu");
$req_lieu->bindValue(':idLieu', $animation['idLieu'], PDO::PARAM_INT);
$req_lieu->execute();
$lieu = $req_lieu->fetch(PDO::FETCH_ASSOC);

// 4 Charger l'animateur
$req_anim = $cnx->prepare("SELECT * FROM animateur WHERE ID = :idAnim");
$req_anim->bindValue(':idAnim', $animation['idAnimateur'], PDO::PARAM_INT);
$req_anim->execute();
$animateur = $req_anim->fetch(PDO::FETCH_ASSOC);

// Pré-remplissage des champs
$datePrefill = substr($animation['DateHeureDeb'], 0, 10);   // YYYY-MM-DD
$heureDebutPrefill = substr($animation['DateHeureDeb'], 11, 5); // HH:MM
$heureFinPrefill = substr($animation['DateHeureFin'], 11, 5);   // HH:MM

?>
