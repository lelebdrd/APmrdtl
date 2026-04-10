<?php
session_start();

if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
}

$nomAffiche = strstr($_SESSION["id"], '.', true);


require('../back_end/rechercher_une_animation.php') ;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=0.621, maximum-scale=1.0, user-scalable=no">
    <title>Création d'animation</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/animation.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/responsive_design_animation.css">
</head>
<body>
<div class = header>
    <h1>Supprimer d'animation</h1>
</div>
<?php require('../include/entetepage.html');?>
<a class = croix href="verif_mardi.php">❌<i class="fas fa-times"></i></a>
<div class="annuler">
<h2>Animations</h2>
<p>Êtes vous sur de vouloir supprimer cette animation ?</p>
</div>
<form method="POST" action="../back_end/annuler_animation_confirmation_verif_mardi.php">
    <input type="hidden" name="id" value="<?= $animation['ID'] ?>">
<table class="annuler_anim">
    <tr>
        <td>Titre :</td>
        <td><?php echo $animation['Titre']; ?></td>
    </tr>
    <tr>
        <td>Commentaire :</td>
        <td><?php echo $animation['commentaire']; ?></td>
    </tr>
    <tr>
        <td>Date :</td>
        <td><?= $datePrefill ?></td>
    </tr>
    <tr>
        <td>Heure début :</td>
        <td><?= $heureDebutPrefill ?> </td>
    </tr>
    <tr>
        <td>Heure fin :</td>
        <td><?= $heureFinPrefill ?></td>
    </tr>

    <tr>
        <td>Minimum d'inscrits :</td>
        <td><?php echo $animation['nbreMin'];?></td>
    </tr>

    <tr>
        <td>Maximum d'inscrits :</td>
        <td><?php echo $animation['nbreMax'];?></td>
    </tr>

    <tr>
        <td>Materiel :</td>
        <td><?php echo $animation['materiel'];?></td>
    </tr>

    <tr>
        <td>Lieu :</td>
        <td><?php require('../back_end/parcourir_lieu.php');
        echo $lieu['batiment']. " ".  $lieu['numsalle'];?></td>
    </tr>

    <tr>
        <td>Animateur :</td>
        <td><?php require('../back_end/parcourir_animateur.php'); 
        echo $animateur['nom']." ". $animateur['prenom'];?></td>
    </tr>

    <tr>
        <td>Thème :</td>
        <td><?php require('../back_end/parcourir_theme.php'); 
        echo $theme['libelle']; ?></td>
    </tr>
                    
</table>
<div class = centrer>

    <button type="submit" class="annulerbtn">Annuler</button>
    </div>
</form> 
</body>
</html>