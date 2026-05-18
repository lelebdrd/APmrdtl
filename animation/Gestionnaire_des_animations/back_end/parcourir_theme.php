<?php
require('../../back_end/include/config.php');

$resultat = $cnx->prepare("select * FROM theme ORDER BY libelle ;");
//le résultat est récupéré sous forme d'objet
$resultat->execute();
$themes = $resultat->fetchAll();
?>