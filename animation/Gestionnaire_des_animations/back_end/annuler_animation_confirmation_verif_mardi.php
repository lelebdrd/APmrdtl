<?php

require('../../back_end/include/config.php');

// Vérifier que l'ID est présent dans l'URL
if (!isset($_POST['id'])) {
    header('Location: ../Gestionnaire_des_animations/front_end/erreur.php?type=animation');
    exit;
}

$id = intval($_POST['id']); // récupère l'ID

$req = $cnx->prepare("
    UPDATE animation 
    SET annulation = 1
    WHERE ID = :id
");
$req->bindValue(':id', $id, PDO::PARAM_INT);
$req->execute();
header('Location: ../front_end/verif_mardi.php');
exit;
?>
