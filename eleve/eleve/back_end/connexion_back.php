<?php
session_start();

//Vérification des champs
if (empty($_POST['identifiant']) || empty($_POST['password'])) {
    echo "Merci de bien renseigner l'ensemble des champs<br />";
    echo "<a href='../connexion.php'>Retour</a>";
}
else {
// Vérification des identifiants
    require_once('verifie_idf_connexion.php');
}
?>