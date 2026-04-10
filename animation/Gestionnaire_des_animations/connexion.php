<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/connexion.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive_design_connexion.css">
</head>
<body>
<div class = header>
    <h1>Connexion</h1>
</div>
<?php require('include/entetepagenoir.html');?>
<div class = centrer>
    <form method="POST" action="connexion_back.php"> 
        <p> Identifiant </p>
        <input type="text" name="identifiant" placeholder="Entrez Votre Email">
        
        
        <p> Mot de passe </p>
        <input type="password" name="mot_de_passe" placeholder="Entrez Votre Mot De Passe">

        <div class = buton >
        <button type="submit" name="connexion"> Connexion </button>
    </div>
    </form>
</div>
</body>
</html>