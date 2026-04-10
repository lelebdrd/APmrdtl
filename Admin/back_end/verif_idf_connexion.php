<?php
require('include/_inc_parametres.php');
require('include/_inc_connexion.php');

// ===============================
// On chiffre l'identifiant entré par l'utilisateur
// ===============================
$identifiant_saisi = $_POST['identifiant'];

$identifiant_chiffre = sodium_crypto_secretbox($identifiant_saisi,$nonce,$cle_secrete);

// On convertit en hex pour comparaison SQL
$identifiant_chiffre_hex = bin2hex($identifiant_chiffre);

// ===============================
// préparation de la requête : recherche de l'utilisateur
// ===============================
$req_pre = $cnx->prepare("SELECT mdp_hash FROM inscrit WHERE emel_chiffr = :id AND STATUT = 4");

$jour = date("N");

// On remplace juste la valeur par la version chiffrée
$req_pre->bindValue(':id', $identifiant_chiffre_hex, PDO::PARAM_STR);
$req_pre->execute();

// Récupération du résultat
$ligne = $req_pre->fetch(PDO::FETCH_OBJ);

// ===============================
// Vérification du mot de passe
// ===============================
if ($ligne && password_verify($_POST['password'], $ligne->mdp_hash)) {

    $_SESSION['connect'] = true;
    $_SESSION['id'] = $identifiant_saisi;

    header('Location:../front_end/comptes_eleves_admin.php');
    exit;
} else {
    header('location:../front_end/page_connexion_admin.php');
    echo "Erreur";
    exit;
}

//$message_dechiffre = sodium_crypto_secretbox_open($texte_chiffre, $nonce, $cle_secrete);

//if ($message_dechiffre === false) {
//// Le texte chiffré, le code MAC, la clé ou le nonce est invalide
//throw new Exception("Erreur de déchiffrement");
//}

//// On affiche le message déchiffré
//echo $message_dechiffre . PHP_EOL;
?>

