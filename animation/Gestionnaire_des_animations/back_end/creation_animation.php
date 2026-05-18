<?php
require('../../back_end/include/config.php');

// Récupération des données du formulaire
$titre       = $_POST['titre'];
$description = $_POST['commentaire'];
$date        = $_POST['date'];
$heureDeb    = $_POST['heureDebut'];
$heureFin    = $_POST['heureFin'];
$minInscrits = $_POST['minInscrits'];
$maxInscrits = $_POST['maxInscrits'];
$materiel    = $_POST['materiel'];
$theme       = $_POST['theme'];
$animateur   = $_POST['animateur'];
$lieu        = $_POST['lieu'];

// Vérification min/max
if ($minInscrits < 1 || $minInscrits > 100) {
    header("Location: ../front_end/creation_animation.php?error=minrange");
    exit;
}

if ($maxInscrits < 1 || $maxInscrits > 100) {
    header("Location: ../front_end/creation_animation.php?error=maxrange");
    exit;
}

if ($maxInscrits < $minInscrits) {
    header("Location: ../front_end/creation_animation.php?error=minmax");
    exit;
}

// Fusion date + heure pour datetime SQL
$dateHeureDeb = $date . " " . $heureDeb . ":00";
$dateHeureFin = $date . " " . $heureFin . ":00";

// Préparation de la requête SQL
$sql = $cnx->prepare("
    INSERT INTO animation 
    (Titre, DateHeureDeb, DateHeureFin, nbreMin, nbreMax, materiel, commentaire, idTheme, idAnimateur, idLieu)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Exécution
$sql->execute([
    $titre,
    $dateHeureDeb,
    $dateHeureFin,
    $minInscrits,
    $maxInscrits,
    $materiel,
    $description,
    $theme,
    $animateur,
    $lieu
]);

// Récupérer l'ID de l'animation créée
$animationID = $cnx->lastInsertId();

// Ajouter automatiquement une ligne dans inscription avec presence = 0
$req = $cnx->prepare("
    INSERT INTO inscription (id_animation, presence)
    VALUES (?, 0)
");
$req->execute([$animationID]);

// Redirection après insertion
header("Location: ../front_end/traitement.php");
exit;

?>
