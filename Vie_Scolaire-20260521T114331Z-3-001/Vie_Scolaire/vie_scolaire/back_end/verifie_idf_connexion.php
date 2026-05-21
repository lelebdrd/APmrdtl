<?php
require('../back_end/include/_inc_parametres.php'); 
require('../back_end/include/_inc_connexion.php');

$cle_secrete = hex2bin("8cdbfa68925c943c6511b5a97f52a229afdaf062eb71b39ab6e0aa485adbeded");
$nonce = hex2bin("35bf64c5deeecc11d10083c42d6e49726d3dbb81de4291a7");

$ident = $_POST['emel'];
$mdp = $_POST['password'];

$texte_chiffre = sodium_crypto_secretbox($ident, $nonce, $cle_secrete);

$req_pre = $cnx->prepare("SELECT mdp_hash FROM administration WHERE emel_chiffre = :id AND STATUT = 3");

$req_pre->bindValue(':id', bin2hex($texte_chiffre), PDO::PARAM_STR);
$req_pre->execute();
$ligne = $req_pre->fetch(PDO::FETCH_OBJ);

if ($ligne && password_verify($mdp, $ligne->mdp_hash)) {
    $_SESSION['connect'] = true;
    $_SESSION['id'] = $ident;
    header('Location: ../vie_scolaire/front_end/lundi_matin_inscriptions.php');
    exit;
}
echo "Erreur sur identifiant ou mot de passe<br>";
echo "<a href='index.php'>Retour</a>";
