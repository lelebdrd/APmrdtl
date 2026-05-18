<?php

require('../../back_end/include/config.php');

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

$limit = 6;
$offset = ($page - 1) * $limit;

// Recherche
$search = $_GET['search'] ?? "";

// Construire la requête dynamique
$query = "
    SELECT 
        a.ID,
        a.Titre,
        a.commentaire,
        a.nbreMin,
        a.nbreMax,
        t.libelle AS theme,
        a.DateHeureDeb,
        a.DateHeureFin
    FROM animation a
    LEFT JOIN theme t ON t.ID = a.idTheme
    WHERE EXISTS (
        SELECT 1 FROM inscription i
        WHERE i.id_animation = a.ID
        AND i.presence = 1
        AND a.annulation = 0
    )
";

// Ajouter filtre recherche
if (!empty($search)) {
    $query .= " AND a.Titre = :search ";
}

// Ajouter ORDER + LIMIT
$query .= " ORDER BY a.DateHeureDeb ASC LIMIT :limit OFFSET :offset";

// Préparer la requête
$sql = $cnx->prepare($query);

// Bind du paramètre search
if (!empty($search)) {
    $sql->bindValue(':search', $search, PDO::PARAM_STR);
}

$sql->bindValue(':limit', $limit, PDO::PARAM_INT);
$sql->bindValue(':offset', $offset, PDO::PARAM_INT);
$sql->execute();
$animations = $sql->fetchAll(PDO::FETCH_ASSOC);

// Compter le total pour la pagination
$countQuery = "
    SELECT COUNT(*) 
    FROM animation a
    WHERE EXISTS (
        SELECT 1 FROM inscription i
        WHERE i.id_animation = a.ID
        AND i.presence = 1
        AND a.annulation = 0
    )
";

if (!empty($search)) {
    $countQuery .= " AND a.Titre LIKE " . $cnx->quote("%$search%");
}
$totalCount = $cnx->query($countQuery)->fetchColumn();
$totalPages = ceil($totalCount / $limit);
?>