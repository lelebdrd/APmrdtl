<?php
require('../../back_end/include/config.php');

$resultat = $cnx->prepare("select * FROM lieu ORDER BY numsalle AND batiment ;");
//le résultat est récupéré sous forme d'objet
$resultat->execute();
$lieus = $resultat->fetchAll();
?>