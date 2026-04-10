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

// SI AU MOINS UNE ANIMATION
if (!empty($themes)):
?>
    <div class="icons-container">

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