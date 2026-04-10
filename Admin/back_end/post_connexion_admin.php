<?php
session_start();

// 1. Vérification des champs
if (empty($_POST['identifiant']) || empty($_POST['password'])) {
    echo "Merci de bien renseigner l'ensemble des champs<br />";
    echo "<a href='../page_connexion_admin.php'>Retour</a>";
}
else {
// 2. Vérification des identifiants
    require_once('verif_idf_connexion.php');
}
?>