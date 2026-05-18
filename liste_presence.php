<?Php
if (!isset($_SESSION ['connect']) || !isset ($_SESSION['id'])) {
    header ('Location:../../index.php');
}
require ('../../include_back_end/config.php');


$resultat = $cnx->prepare("select * FROM inscrit INNER JOIN inscription ON inscrit.id_inscrit = inscription.id_inscrit INNER JOIN animation ON inscription.id_animation=animation.id_animation order by inscrit.ID ASC")
$result->excute();
$inscrit = $resultat->fetchAll();//“récupérer tous les résultats d’une requête”,
foreach ($eleves as $e)
echo "ID" :$eleves ['id'];
echo "nom" :$eleves ['nom'];
echo "prenom" :$eleves ['prenom'];
?>