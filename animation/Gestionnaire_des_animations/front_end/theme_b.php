<?php 
session_start();

if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animation du Thème B</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/Gestionaire.css">
</head>
<body>
<div class = header>
    <h1>Thème B</h1>
</div>
<?php require('../include/entetepage.html');?>
<a class = croix href="traitement.php">❌<i class="fas fa-times"></i></a>
</body>
</html>