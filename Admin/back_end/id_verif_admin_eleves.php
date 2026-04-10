<?php
require('connexion_admin.php');

 // préparation de la requête : recherche d'un stage particulier
$req_pre = $connexion->prepare("SELECT inscrit.nom,inscrit.prenom,inscrit.tel,inscrit.emel_chiffr,statut.libelle FROM inscrit,statut where inscrit.STATUT = statut.ID and inscrit.STATUT = 1 and inscrit.ID = :id");

// liaison de la variable à la requête préparée
$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
$req_pre->execute();
//le résultat est récupéré sous forme d'objet
$article=$req_pre->fetch();
?>