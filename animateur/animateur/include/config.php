<?php
$host = "localhost";
$dbname = "animation";
$username = "intervenant";
$password = "Btssio2017";

try {
    $cnx = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cnx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
