<?php
$erreur = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courriel = $_POST['courriel'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    
    // Vérification des champs
    if (empty($courriel) || empty($mdp)) {
        $erreur = 'Veuillez remplir tous les champs';
    } else {
        // Requête pour vérifier l'utilisateur (administrateur seulement)
        $requete = $connexion->prepare("SELECT * FROM statut, insctrit, administration WHERE statut.ID = '4' AND insctrit.STATUT = statut.ID AND administration.STATUT = statut.ID AND (insctrit.emel = :courriel OR administration.emel = :courriel)");
        $requete->bindParam(':courriel', $courriel);
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
        
        // Comparaison simple
        if ($utilisateur && $mdp === $utilisateur['MDP_UT']) {
            // Connexion réussie
            session_start();
            $_SESSION['utilisateur_administrateur'] = $utilisateur;
            header('Location: compte_autres_admin.php');
            exit();
        } else {
            $erreur = 'Courriel ou mot de passe incorrect, ou vous n\'êtes pas administrateur';
        }
    }

}
?>