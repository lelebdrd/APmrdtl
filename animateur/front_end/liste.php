<?php
require "config.php";

$req = $pdo->query("SELECT * FROM animations");
$animations = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Listes des animations</h1>

<?php foreach ($animations as $a): ?>
    <p>
       
       <strong><?= htmlspecialchars($a['titre']) ?></strong><br>
       <?= nl2br(htmlspecialchars($a['description'])) ?><br>
       <em><?= $a['date_evenement']?></em><br>
       <a href= "modifier.php=<?= $a['id'] ?>">Modifier</a>

</p>
<?php endforeach; ?>
