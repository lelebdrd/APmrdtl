<?php
require "config.php";

if (!empty($_POST['id'])) && !empty($_POST['titre']) && !empty(_$POST['description']) {
   $sql = "Mise a jour d'animation
           SET titre = :titre, description = :description, date_evenement = :date_evenement
           WHERE id = :id";
    $stmt = $echo->prepare($sql);
    $stmt-> execute([
        ': titre' => $_POST['titre'],
        ': description'=> $_POST['description'],
        ': date_evenement'=> $_POST['date_evenement']
        ': id' => $_POST ['id']

    ]);

    echo "Modification enregistrée  !";
    echo "<br><a href='Liste.php'>Retour</a>";
 } else{
     echo "Champs manquants.";
     
 }
