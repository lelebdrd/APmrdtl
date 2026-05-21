<?php
session_start();
if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location: ../../index.php');
    exit;
}
require('../../back_end/include/_inc_parametres.php');
require('../../back_end/include/_inc_connexion.php');

if (!empty($_POST['action']) && is_array($_POST['action'])) {
    foreach ($_POST['action'] as $id_inscrit => $animations) {
        foreach ($animations as $id_animation => $choix) {

            if ($choix === 'annuler') {
                // Supprime l'inscription
                $req = $cnx->prepare("
                    DELETE FROM inscription
                    WHERE id_inscrit = :id_inscrit AND id_animation = :id_animation
                ");
                $req->bindValue(':id_inscrit',   $id_inscrit,   PDO::PARAM_INT);
                $req->bindValue(':id_animation', $id_animation, PDO::PARAM_INT);
                $req->execute();

            } elseif ($choix === 'confirmer') {
                // Marque l'inscription comme confirmée
                $req = $cnx->prepare("
                    UPDATE inscription SET confirme = TRUE
                    WHERE id_inscrit = :id_inscrit AND id_animation = :id_animation
                ");
                $req->bindValue(':id_inscrit',   $id_inscrit,   PDO::PARAM_INT);
                $req->bindValue(':id_animation', $id_animation, PDO::PARAM_INT);
                $req->execute();
            }

        }
    }
}

header('Location: ../front_end/lundi_matin_inscriptions.php');
exit;