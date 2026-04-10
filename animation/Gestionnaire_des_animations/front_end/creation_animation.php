<?php
session_start();

if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
}


$datePrefill = $_GET['date'] ?? "";
$heurePrefill = $_GET['heure'] ?? "";
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

<div class="header">
    <h1>Création d'animations</h1>
</div>

<?php require('../include/entetepage.html'); ?>
<a class = croix href="traitement.php">❌<i class="fas fa-times"></i></a>
<div class="centrer">
<h2>Animations</h2>
<p>Sur cette page, vous pouvez ajouter une animation.</p>
</div>
<?php  
if (isset($_GET['error'])) {
    if ($_GET['error'] == "minrange") echo "<p style='color:red;'>Le minimum doit être entre 1 et 100.</p>";
    if ($_GET['error'] == "maxrange") echo "<p style='color:red;'>Le maximum doit être entre 1 et 100.</p>";
    if ($_GET['error'] == "minmax") echo "<p style='color:red;'>Le maximum doit être supérieur ou égal au minimum.</p>";
}
?>

<form method="POST" action="../back_end/creation_animation.php">
    <table class="table table-striped">

        <tr>
            <td>Titre :</td>
            <td><input type="text" name="titre" required></td>
        </tr>

        <tr>
            <td>Commentaire :</td>
            <td><textarea name="commentaire" rows="10" required></textarea></td>
        </tr>

        <tr>
            <td>Date :</td>
            <td><input type="date" name="date" value="<?= $datePrefill ?>" required></td>
        </tr>

        <tr>
            <td>Heure début :</td>
            <td><input type="time" name="heureDebut" value="<?= $heurePrefill ?>" required></td>
        </tr>

        <tr>
            <td>Heure fin :</td>
            <td><input type="time" name="heureFin" required></td>
        </tr>

        <tr>
            <td>Minimum d'inscrits :</td>
            <td><input type="number" name="minInscrits" min="1" max="100" required></td>
        </tr>

        <tr>
            <td>Maximum d'inscrits :</td>
            <td><input type="number" name="maxInscrits" min="1" max="100" required></td>
        </tr>

        <tr>
            <td>Matériel :</td>
            <td><input type="text" name="materiel"></td>
        </tr>

        <tr>
            <td>Lieu :</td>
            <td>
                <?php 
                require('../back_end/parcourir_lieu.php');

                echo '<select name="lieu">';
                foreach ($lieus as $lieu) {
                    echo "<option value='".$lieu['ID']."'>".$lieu['batiment']." - ".$lieu['numsalle']."</option>";
                }
                echo '</select>';
                ?>
            </td>
        </tr>

        <tr>
            <td>Animateur :</td>
            <td>
                <?php 
                require('../back_end/parcourir_animateur.php');

                echo '<select name="animateur">';
                foreach ($animateurs as $animateur) {
                    echo "<option value='".$animateur['ID']."'>".$animateur['nom']." ".$animateur['prenom']."</option>";
                }
                echo '</select>';
                ?>
            </td>
        </tr>

        <tr>
            <td>Thème :</td>
            <td>
                <?php 
                require('../back_end/parcourir_theme.php');

                echo '<select name="theme">';
                foreach ($themes as $theme) {
                    echo "<option value='".$theme['ID']."'>".$theme['libelle']."</option>";
                }
                echo '</select>';
                ?>
            </td>

        </tr>

    </table>

    <div class="centrer">
        <button type="submit">Enregistrer</button>
    </div>

</form>

</body>
</html>
