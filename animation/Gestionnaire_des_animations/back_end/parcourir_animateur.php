<?php
require('../../back_end/include/config.php');

$resultat = $cnx->prepare("select * FROM animateur ORDER BY nom AND prenom ;");
//le résultat est récupéré sous forme d'objet
$resultat->execute();
$animateurs = $resultat->fetchAll();
?>