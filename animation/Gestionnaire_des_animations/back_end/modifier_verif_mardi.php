<?php
require('../../back_end/include/config.php');

$id = $_POST['numero'];
$date = $_POST['date'];
$heureDeb = $_POST['debut'];
$heureFin = $_POST['fin'];
$dateHeureDeb = $date . " " . $heureDeb . ":00"; 
$dateHeureFin = $date . " " . $heureFin . ":00";

$req = $cnx->prepare("
    UPDATE animation 
    SET 
        Titre = :nom,
        commentaire = :com,
        nbreMin = :nbmin,
        nbreMax = :nbmax,
        materiel = :materiel,
        DateHeureDeb = :deb,
        DateHeureFin = :fin,
        idTheme = :theme,
        idAnimateur = :admin,
        idLieu =:lieu
    WHERE ID = :id
");

$req->bindValue(':nom', $_POST['nom']);
$req->bindValue(':com', $_POST['com']);
$req->bindValue(':nbmin', $_POST['nbmin']);
$req->bindValue(':nbmax', $_POST['nbmax']);
$req->bindValue(':materiel', $_POST['materiel']);
$req->bindValue(':deb', $dateHeureDeb);
$req->bindValue(':fin', $dateHeureFin);
$req->bindValue(':theme', $_POST['theme']);
$req->bindValue(':admin', $_POST['admin']);
$req->bindValue(':lieu', $_POST['lieu']);
$req->bindValue(':id', $_POST['numero']);

$req->execute();

header('Location:../front_end/verif_mardi.php');
exit;
?>
