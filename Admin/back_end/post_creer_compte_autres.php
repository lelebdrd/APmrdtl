<?php
require ('..\back_end\connexion_admin.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $phone = $_POST['phone'];
        $emel = $_POST['emel'];
        $statut = $_POST['statut'];
    if (EMPTY($statut)=== true || EMPTY($nom)=== true || EMPTY($prenom)=== true || EMPTY($phone)=== true || EMPTY($emel)=== true) {
        echo "une valeur est vide<br>";
    } else {
        if ($statut == 2) {
            $requete = $connexion->prepare("INSERT INTO animateur (nom, prenom, tel, emel) VALUES (:nom, :prenom, :tel, :emel)");
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':tel', $phone);
            $requete->bindParam(':emel', $emel);
        } else {
            $requete = $connexion->prepare("INSERT INTO inscrit (nom, prenom, tel, emel, statut) VALUES (:nom, :prenom, :tel, :emel, :statut)");
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':tel', $phone);
            $requete->bindParam(':emel', $emel);
            $requete->bindParam(':statut', $statut);
        }
        $requete->execute();
        header("Location: ../front_end/compte_autres_admin.php");
    }
} else {
    echo "Aucune donnée reçue<br>";
}
?>