<?php
// Informations de connexion
$host = "localhost";
$dbname = "animation";
$username = "animation";
$password = "animation22";

try {
    // Connexion à la base de données
    $cnx = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    // Activer les erreurs PDO (recommandé)
    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cnx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
} 
?>
