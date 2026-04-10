<?php
require('include/config.php');


// Clé et nonce utilisés pour chiffrer les identifiants

$cle_secrete = hex2bin("ada74470449cb6ca929713d3e97313f86f3b0f2783f3937a024bb04b7c9fb311");
$nonce = hex2bin("6829f4813216c73bd71d92758943fe5d2d76ef1611072842");


// On chiffre l'identifiant entré par l'utilisateur

$identifiant_saisi = $_POST['identifiant'];

$identifiant_chiffre = sodium_crypto_secretbox($identifiant_saisi,$nonce,$cle_secrete);

// On convertit en hex pour comparaison SQL
$identifiant_chiffre_hex = bin2hex($identifiant_chiffre);


// préparation de la requête : recherche de l'utilisateur

$req_pre = $cnx->prepare("SELECT mdp_hash FROM animateur WHERE emel_chiffre = :id");



// On remplace juste la valeur par la version chiffrée
$req_pre->bindValue(':id', $identifiant_chiffre_hex, PDO::PARAM_STR);
$req_pre->execute();

// Récupération du résultat
$ligne = $req_pre->fetch(PDO::FETCH_OBJ);


// Vérification du mot de passe

if ($ligne && password_verify($_POST['Mot_de_passe'], $ligne->mdp_hash)) {

    $_SESSION['connect'] = true;
    $_SESSION['id'] = $identifiant_saisi;

   

    header('Location:../animateur/front_end/accueil.php');
    exit;
} else {
    echo " message d'erreur";
    header('Location: ../animateur/connexion.php');
    exit;
}

?>
