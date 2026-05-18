<?php
session_start();

if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
}

require('../back_end/traitement.php') ;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Traitements d'animations</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/traitement.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/responsive_design_traitement.css">

</head>
<body>

<div class="header">
    <h1>Traitements d'animations</h1>
</div>


<?php require('../include/entetepagetraitement.html'); ?>

<!-- Navigation semaines &#62 et 60; <- -> -->
<div class="semaine">
    <a href="?semaine=<?= $semainePrec ?>&annee=<?= $anneePrec ?>">&#60;</a>
    &nbsp;&nbsp;
    Semaine <?= $semaine ?> - <?= $annee ?>
    &nbsp;&nbsp;
    <a href="?semaine=<?= $semaineSuiv ?>&annee=<?= $anneeSuiv ?>">&#62;</a> 
</div>

<div class="cal-wrapper">
<table id="calendrier">

    <!-- Ligne des dates complètes -->
    <thead>
        <tr>
            <th>Heure</th>
            <?php foreach ($jours as $nom => $date): ?>
            <th><?= $nom . " " . $fmt->format($date) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <!-- Lignes des heures -->
        <?php foreach ($heures as $h): ?>
            <tr>
                <td><?= substr($h, 0, 2) . "h" ?></td>

            <?php foreach ($jours as $date): ?>
            <td>
                <?php
$dateSQL = $date->format('Y-m-d');
$heureSQL = $h;

$sql = $cnx->prepare("
    SELECT ID, idTheme, TIME(DateHeureDeb) AS deb, TIME(DateHeureFin) AS fin
    FROM animation 
    WHERE DATE(DateHeureDeb) = ?
    AND TIME(DateHeureDeb) <= ?
    AND TIME(DateHeureFin) >= ?
    AND annulation = 0
");
$sql->execute([$dateSQL, $heureSQL, $heureSQL]);

// Récupère toutes les animations de la case
$anims = $sql->fetchAll(PDO::FETCH_ASSOC);

// Toujours un tableau, même vide
$themes = array_column($anims, 'idTheme');

$imagesThemes = [
    1 => "patisserie.png",
    2 => "refugelpo.png",
];

// SI AU MOINS UNE ANIMATION
if (!empty($themes)):
?>
    <div class="icons-container">

        <?php foreach ($anims as $anim): ?>
            <div class="case-anim">
                <!-- Affichage des heures -->
    <div class="heure-anim">
        <?= substr($anim['deb'], 0, 5) ?> - <?= substr($anim['fin'], 0, 5) ?>
    </div>

                <!-- Image cliquable vers la page de modification -->
                <a href="modifier_animation.php?id=<?= $anim['ID'] ?>">
                    <img src="../../assets/img/<?= $imagesThemes[$anim['idTheme']] ?>" class="icone-theme">
                </a>

                <!-- Menu supprimer au survol -->
                <div class="menu-suppr">
                    <a href="annuler_animation.php?id=<?= $anim['ID'] ?>">Supprimer</a>
                </div>

            </div>
        <?php endforeach; ?>

        <!-- Toujours possibilité d'ajouter -->
        <a href="creation_animation.php?date=<?= $dateSQL ?>&heure=<?= $h ?>" class="icone-plus">+</a>

    </div>

<?php else: ?>

    <!-- Aucune animation juste un + -->
    <a href="creation_animation.php?date=<?= $dateSQL ?>&heure=<?= $h ?>" class="icone-plus">+</a>

<?php endif; ?>


            </td>
        <?php endforeach; ?>

    </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</body>
</html>