<?php
session_start();

// 1. Vérification des champs
if (empty($_POST['identifiant']) || empty($_POST['mot_de_passe'])) {
    header('Location: ../Gestionnaire_des_animations/front_end/erreur.php?type=champs');
    exit;
}
else {
// 2. Vérification des identifiants
    require_once('back_end/verifie_idf_connexion.php');
}
?>
