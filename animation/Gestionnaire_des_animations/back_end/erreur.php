<?php
// Récupération du type d'erreur envoyé par l'URL
$type = $_GET['type'] ?? "inconnu";

// Liste des messages d'erreur possibles
$messages = [
    "champs" => "Merci de remplir tous les champs.",
    "login"  => "Identifiant ou mot de passe incorrect.",
    "acces_interdit" => "Vous n'avez pas les droits pour accéder à cette page.",
    "inconnu" => "Une erreur inconnue est survenue.",
    "animation" => "Aucune animation sélectionnée."
];

// On choisit le message correspondant
$message = $messages[$type] ?? $messages["inconnu"];
?>