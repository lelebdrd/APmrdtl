<?php
$pdo = new PDO ("mysql:host=localhost;dbname=animation;charset=utf8", "root", "");
$sql = "Select id ,nom, email FROM inscription WHERE animation_id = :id";
$stm = $pdo->prepare($sql);
$stm->execute();
$inscrit = $stm->fetchall(PDO::FETCH_ASSOC);
foreach ($inscrit as $i) {
    echo $i['id'] ."".$i ['nom']."". $i ['email']."". 
}
    
?>            