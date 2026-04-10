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
            $requete = $connexion->prepare("UPDATE animateur SET nom = :nom, prenom = :prenom, tel = :tel, emel_chiffr = :emel_chiffr WHERE id = :id");
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':tel', $phone);
            $nonce = hex2bin("6829f4813216c73bd71d92758943fe5d2d76ef1611072842");
            $cle_secrete = hex2bin("ada74470449cb6ca929713d3e97313f86f3b0f2783f3937a024bb04b7c9fb311");
            $emel_chiffr = bin2hex(sodium_crypto_secretbox($emel, $nonce, $cle_secrete));
            $requete->bindParam(':emel_chiffr', $emel_chiffr);
        } else {
            $requete = $connexion->prepare("UPDATE inscrit SET nom = :nom, prenom = :prenom, tel = :tel, emel = :emel, statut = :statut WHERE id = :id");
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':tel', $phone);
            $requete->bindParam(':emel', $emel);
            $requete->bindParam(':statut', $statut);
        }
        $requete->bindParam(':id', $_GET['id']);
        $requete->execute();
        header("Location: ../front_end/compte_autres_admin.php");
    }
} else {
    echo "Aucune donnée reçue<br>";
}
?>