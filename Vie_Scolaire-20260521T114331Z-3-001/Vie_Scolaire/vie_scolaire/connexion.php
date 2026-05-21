<?php
if ($_POST['emel'] == '' OR $_POST['password'] == '') {
            echo "Merci de bien renseigner l'ensemble des champs";
            echo "<br />";
            echo "<a href='index.php'>Retour</a>";
}
else
{   // démarrage de la session et sauvegarde des informations dans 2 variables
            
    session_start();
    require_once('back_end/verifie_idf_connexion.php');
    // la variable de session connect vaut true ou false!!!!!!!!
    
}
?>