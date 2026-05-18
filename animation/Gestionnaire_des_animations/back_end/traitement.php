<?php
require('../../back_end/include/config.php');
date_default_timezone_set('Europe/Paris');

// Activer la locale française
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');

// Formatter moderne pour les dates en français
$fmt = new IntlDateFormatter(
    'fr_FR',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    'Europe/Paris',
    IntlDateFormatter::GREGORIAN,
    'd MMMM yyyy'
);

// Récupérer la semaine demandée ou prendre la semaine actuelle
$semaine = isset($_GET['semaine']) ? intval($_GET['semaine']) : intval(date('W'));
$annee   = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));

// Trouver le lundi de cette semaine
$lundi = new DateTime();
$lundi->setISODate($annee, $semaine);

// Générer les dates des 5 jours
$jours = [
    'Lundi'    => clone $lundi,
    'Mardi'    => (clone $lundi)->modify('+1 day'),
    'Mercredi' => (clone $lundi)->modify('+2 days'),
    'Jeudi'    => (clone $lundi)->modify('+3 days'),
    'Vendredi' => (clone $lundi)->modify('+4 days'),
];

// Générer les heures de 08:00 à 18:00
$heures = [];
for ($h = 8; $h <= 18; $h++) {
    $heures[] = sprintf('%02d:00', $h);
}

// Calcul des semaines précédente et suivante
$semainePrec = $semaine - 1;
$semaineSuiv = $semaine + 1;

$anneePrec = $annee;
$anneeSuiv = $annee;

if ($semainePrec < 1) {
    $semainePrec = 52;
    $anneePrec--;
}

if ($semaineSuiv > 52) {
    $semaineSuiv = 1;
    $anneeSuiv++;
}
?>