<?php
session_start();

// 1.Vérification des champs
if (empty($_POST['identifiant'])|| empty($_POST['mot de passe'])){
    echo "Merci de bien renseigner l'ensemble des champs <br/>";
    echo "<a href='connexion.php'>Retour</a>";
}
else {
    // 2. Vérification des identifiants
    require_once ('back_end/verifie_connexion.php');
}
?>