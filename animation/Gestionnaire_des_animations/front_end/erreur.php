<?php
session_start();

if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
}
require('../back_end/erreur.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Traitements d'animations</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/connexion.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/responsive_design_connexion.css">
</head>
<body>

<div class="header-erreur">
    <h1>Erreur</h1>
</div>


<?php require('../include/entetepagenoir.html'); ?>

<div class="centrer">
    <div class="erreur-box">
        <p class="erreur-titre">Erreur</p>
        <p><?= $message ?></p>

        <a class="erreur-retour" href="../connexion.php">Retour</a>
    </div>
</div>

</body>
</html>
