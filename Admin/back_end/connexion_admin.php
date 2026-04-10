<?php
/*les paramètres de connexion a la base de donnée*/
$machine="localhost";
$port=3306;
$utilisateur="admin";
$motdepasse="mmdDpP%ss2";
$nomdebase="animationsfld";
/*creation de la connexion et activation des avertissements en cas d’erreur*/
$connexion=new PDO('mysql:host='.$machine.';port='.$port.';dbname='.$nomdebase, $utilisateur,
$motdepasse);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>
