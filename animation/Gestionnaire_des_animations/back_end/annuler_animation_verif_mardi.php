<?php

require('../../back_end/include/config.php');

// Vérifier que l'ID est présent dans l'URL
if (!isset($_POST['id'])) {
    header('Location: ../Gestionnaire_des_animations/front_end/erreur.php?type=animation');
    exit;
}

$id = intval($_POST['id']); // récupère l'ID
header('Location:../front_end/annuler_animation_confirmation_verif_mardi.php?id=' . $id);    
exit;
?>
