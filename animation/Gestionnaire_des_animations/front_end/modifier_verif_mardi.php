<?php
session_start();

if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
}

require('../back_end/rechercher_une_animation.php') ;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=0.621, maximum-scale=1.0, user-scalable=no">
    <title>Création d'animation</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/animation.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/responsive_design_verif_mardi.css">
</head>
<body>

<div class = header>
    <h1>Modification d'animation</h1>
</div>
<?php require('../include/entetepage_verif.html');?>
<a class = croix href="verif_mardi.php">❌<i class="fas fa-times"></i></a>
<div class="centrer">
<h2>Animations</h2>
<p>Sur cette page, vous pouvez ajouter une animation.</p>
</div>
<form method="POST" action="../back_end/modifier_verif_mardi.php">
<input type="hidden" name="numero" value="<?= $animation['ID'] ?>">
<table>
    <tr>
        <td>Titre :</td>
        <td><input type='text' name='nom' value='<?php echo $animation['Titre']; ?>'/></td>
    </tr>
    <tr>
        <td>Commentaire :</td>
        <td><textarea name="com" rows="10"><?= htmlspecialchars($animation['commentaire']) ?></textarea></td>
    </tr>
    <tr>
        <td>Date :</td>
        <td><input type="date" name="date" value="<?= $datePrefill ?>" ></td>
    </tr>
    <tr>
        <td>Heure début :</td>
        <td><input type='time' name='debut' value='<?= $heureDebutPrefill ?>'/> </td>
    </tr>
    <tr>
        <td>Heure fin :</td>
        <td><input type='time' name='fin' value='<?= $heureFinPrefill ?>'/></td>
    </tr>

    <tr>
        <td>Minimum d'inscrits :</td>
        <td><input type="number" name="nbmin" min="1" max="100" value='<?php echo $animation['nbreMin'];?>'></td>
    </tr>

    <tr>
        <td>Maximum d'inscrits :</td>
        <td><input type="number" name="nbmax" min="1" max="100" value='<?php echo $animation['nbreMax'];?>'></td>
    </tr>

    <tr>
        <td>Materiel :</td>
        <td><input type="text" name="materiel" value='<?php echo $animation['materiel'];?>'></td>
    </tr>

    <tr>
        <td>Lieu :</td>
        <td><?php require('../back_end/parcourir_lieu.php'); ?> <select name="lieu"> 
            <?php foreach ($lieus as $lieu): ?> 
            <option value="<?php echo $lieu['ID']; ?>" 
            <?php if ($lieu['ID'] == $animation['idLieu']) echo "selected"; ?>> 
            <?php echo $lieu['batiment']; ?> 
            <?php echo $lieu['numsalle']; ?> 
            </option> 
        <?php endforeach; ?></td>
    </tr>

    <tr>
        <td>Animateur :</td>
        <td><?php require('../back_end/parcourir_animateur.php'); ?> <select name="admin"> 
            <?php foreach ($animateurs as $animateur): ?> 
            <option value="<?php echo $animateur['ID']; ?>" 
            <?php if ($animateur['ID'] == $animation['idAnimateur']) echo "selected"; ?>> 
            <?php echo $animateur['nom']; ?> 
            </option> 
        <?php endforeach; ?></td>
    </tr>

    <tr>
        <td>Thème :</td>
        <td><?php require('../back_end/parcourir_theme.php'); ?> <select name="theme"> 
            <?php foreach ($themes as $theme): ?> 
            <option value="<?php echo $theme['ID']; ?>" 
            <?php if ($theme['ID'] == $animation['idTheme']) echo "selected"; ?>> 
            <?php echo $theme['libelle']; ?> 
            </option> 
        <?php endforeach; ?></td>
    </tr>
                    
</table>
<div class = centrer>

    <button type="submit">Modifier</button>
    </div>
</form> 

</body>
</html>