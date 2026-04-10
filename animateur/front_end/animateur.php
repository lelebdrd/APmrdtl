<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Animateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-container">
        <h1>Connexion</h1>

        <form action="#" method="post">
            <div class="form-group">
                <p for="identifiant">identifiant</p>
                <input type="text"  name="identifiant" required>
            </div>

            <div class="form-group">
                <p for="Mot de passe">Mot de passe</p>
                <input type="Mot de passe" name="Mot de passe" required>
            </div>

            <button type="submit">Se connecter</button>
        </form>
    </div>
<?php
// Le message en clair
$message = "nathalie.lopez@gmail.com";

// Génération de la clé secrète
$cle_secrete = hex2bin("ada74470449cb6ca929713d3e97313f86f3b0f2783f3937a024bb04b7c9fb311");

// Affichage de la clé en hexadécimal
echo bin2hex($cle_secrete) . "<br>";

// Génération du nonce
$nonce = hex2bin("6829f4813216c73bd71d92758943fe5d2d76ef1611072842");

// Chiffrement du message
$texte_chiffre = sodium_crypto_secretbox($message, $nonce, $cle_secrete);

// Affichage du texte chiffré et du nonce
echo bin2hex($texte_chiffre) . "<br>";
echo bin2hex($nonce) . "<br>";

// On dechiffre le texte chiffré avec la fonction sodium_crypto_secretbox_open
// Notez qu'il est nécessaire de connaitre le nonce pour déchiffrer le texte. Le nonce peut être transmit en clair en même temps que le texte chiffré
$message_dechiffre = sodium_crypto_secretbox_open($texte_chiffre, $nonce, $cle_secrete);

if ($message_dechiffre === false) {
// Le texte chiffré, le code MAC, la clé ou le nonce est invalide
throw new Exception("Erreur de déchiffrement");
}

// On affiche le message déchiffré
echo $message_dechiffre . PHP_EOL;
?>
</body>
</html>
