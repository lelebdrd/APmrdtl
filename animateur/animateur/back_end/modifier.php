<?php
require "config.php";

if (!isset($_Get['id'])){
    die("ID manquant");
}

$id = $Get['id'];

$req = $pdo->prepare("SELECT *FROM animations WHERE id = :id");
$req->execute(['id' =>$id]);
$animations = $req->fetch(PDO::FETCH_ASSOC);

if (!$animation) {
    die("Animation introuvable");
}
?>

<h1> Modifier l'animation</h1>

<form method="POST"  action="modifier.php">
    <input type="hidden" name="id"  value="<?= $animation['id'] ?>"

     < input type="texte" name="titre" value="<?=htmlspecialchars($animation['titre']) ?>"

     <p> Description </p>
    <input type="text" name="titre" value="<?=htmlspecialchars($animation['description']) ?>">

    <p>Date :</p>
    <input type="date" name="date_evenement" value="<?= $animations['date_evement'] ?>">

    <button type="submit">Enregistrer</button>

</form> 