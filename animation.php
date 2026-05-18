<?php
require ('../back_end/presence.php')
$sql = "select id ,idLieu,Titre,annulation, commentaire , materiel, DateHeureDeb,DateHeureFin From animation;
$stm = $pdo->prepare($sql);
$stm->execute();
foreach ($a as $animation) {

  echo "ID" :$animation ['id'];
   echo "idLieu" :$animation['idLieu'] ;
   echo  "Titre" : $animation ['Titre'];
    echo "annulation": $animation ['annulation'];
    echo "commentaire": $animation ['commentaiere'];
    echo"materiel":$animation ['materiel'];
    echo"Debut" : $animation ['DateHeureDeb'];
    echo"Fin": $animation ['DateHeureFin'];
    
}
?>