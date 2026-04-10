<?php
session_start();

if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location:../../index.php');
}

require('../back_end/passe_animation.php')
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toutes les animations</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/inscrit.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/responsive_design_inscrit.css">
</head>
<body>

<div class="header">
    <h1>Passer animation</h1>
</div>

<?php require('../include/entetepage.html'); ?>
<a class = croix href="traitement.php">❌<i class="fas fa-times"></i></a>
<div class="centrer">
<!-- Barre de recherche -->
<form method="GET" class="search-bar">
    <input type="text" name="search" placeholder="Rechercher une animation..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">🔍</button>
</form>

<h2>Liste des animations</h2>
</div>
<div class="container-animations">

<?php if (empty($animations)): ?>
    <p class="no_animation">Aucune animation trouvée.</p>
<?php endif; ?>

<?php foreach ($animations as $anim): ?>
    <div class="bloc-animation">
        <p><strong>Titre :</strong> <?= $anim['Titre'] ?></p>
        <p><strong>Description :</strong> <?= $anim['commentaire'] ?></p>
        <p><strong>Nb min/max :</strong> <?= $anim['nbreMin'] ?> / <?= $anim['nbreMax'] ?></p>
        <p><strong>Thème :</strong> <?= $anim['theme'] ?></p>
        <p><strong>Date :</strong> <?= substr($anim['DateHeureDeb'], 0, 10) ?></p>
        <p><strong>Heures :</strong> 
            <?= substr($anim['DateHeureDeb'], 11, 5) ?> → <?= substr($anim['DateHeureFin'], 11, 5) ?>
        </p>
    </div>
<?php endforeach; ?>

</div>

<!-- Pagination -->
<div class="pagination">

    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>" class="fleche">◀</a>
    <?php endif; ?>

    <span>Page <?= $page ?> / <?= $totalPages ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>" class="fleche">▶</a>
    <?php endif; ?>

</div>

</body>
</html>
