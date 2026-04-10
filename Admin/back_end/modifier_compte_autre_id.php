<?php
require('connexion.php');

 // préparation de la requête : recherche d'un stage particulier
$req_pre = $connexion->prepare("SELECT * FROM article JOIN categorie on article.ID_CAT = categorie.ID_CAT WHERE ID_ART = :id");

// liaison de la variable à la requête préparée
$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$req_pre->execute();
//le résultat est récupéré sous forme d'objet
$article=$req_pre->fetch();
?>