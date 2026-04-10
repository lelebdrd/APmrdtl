<?php
require('include/_inc_parametres.php');
require('include/_inc_connexion.php');


$identifiant_saisi = $_POST['identifiant'];

// Chiffrement de l'email avec clé secrète et nonce
$identifiant_chiffre = sodium_crypto_secretbox($identifiant_saisi, $nonce, $cle_secrete);

$identifiant_chiffre_hex = bin2hex($identifiant_chiffre);

$req_pre = $cnx->prepare("SELECT mdp_hash FROM inscrit WHERE emel_chiffr = :id AND STATUT = 1");

//protection injection SQL
$req_pre->bindValue(':id', $identifiant_chiffre_hex, PDO::PARAM_STR);
$req_pre->execute();

$ligne = $req_pre->fetch(PDO::FETCH_OBJ);

if ($ligne && password_verify($_POST['password'], $ligne->mdp_hash)) {
    // password_verify() compare mot de passe avec hash stocké en BDD

    $_SESSION['connect'] = true;
    $_SESSION['id'] = $identifiant_saisi;

    header('Location:../front_end/animations.php');
    exit;

} else {
    header('location:../connexion.php');
    exit;
}
?>