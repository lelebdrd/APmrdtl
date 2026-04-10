<?php 
// Inclusion du fichier de connexion à la base de données
require ('..\back_end\connexion_admin.php');
// hi there pal
?>
<html>
        <head>
        
            <title>Compte élèves</title>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="author" content="Timothe Pellen">
            <meta name="description" content="Page de gestion des comptes élèves"> 
            
            <meta name="keywords" content="BTS SIO, BTS SIO SISR, BTS SIO SLAM, métiers informatique, administrateur réseau, développeur web, technicien support, analyste de données, jeux vidéo, cybersécurité, cloud computing, gestion de projet informatique, consultant IT, ingénieur logiciel, architecte réseau, spécialiste en sécurité informatique">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
            <link rel="stylesheet" href="../assets/css/tableau.css">
        </head>
        <?php
            include 'nav_admin.php';
        ?>
        <body>
            <div class="row">
                <div class="col container mt-2"></div>
                <button class="btn btn-primary mt-3 mb-3 disabled"><a href="admin_page.php" class="text-light text-decoration-none">supprimé les comptes élèves</a></button>
                <div class="col container mt-2"></div>
                <button class="btn btn-primary mt-3 mb-3"><a href="générer_comptes_eleves.php" class="text-light text-decoration-none">générer les nouveaux élèves</a></button>
                <div class="col container mt-2"></div>
            </div>
            <table class="table_a_moi table-dark">
                <thead>
                    <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Numero de téléphone</th>
                    <th scope="col">Adresse Email</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Récupération des articles de la catégorie actuelle
                    $requete = $connexion->prepare('SELECT * FROM `inscrit` where inscrit.STATUT = 1');
                    $requete->execute();
                    $lignes = $requete->fetchAll();
                    // Boucle sur chaque article de la catégorie
                    $nonce = hex2bin("6829f4813216c73bd71d92758943fe5d2d76ef1611072842");
                    $cle_secrete = hex2bin("ada74470449cb6ca929713d3e97313f86f3b0f2783f3937a024bb04b7c9fb311");
                    foreach($lignes as $ligne)  
                    {
                        $texte_chiffre = hex2bin($ligne["emel_chiffr"]);
                        $message_dechiffre = sodium_crypto_secretbox_open($texte_chiffre, $nonce, $cle_secrete);
                    ?>
                        <tr>
                            <th><?php echo $ligne["nom"]; ?></th>
                            <td><?php echo $ligne["prenom"]; ?></td>
                            <td><?php echo $ligne["tel"]; ?></td>
                            <td><?php echo $message_dechiffre . PHP_EOL; ?></td>
                            <td>
                                <button class="btn btn-sm btn-secondary"><img class="icons img-fluid" src="../assets/images/resetpass.png" alt="réinitialiser le mot de passe"></button>
                                <button class="btn btn-sm btn-secondary"><a href="modifier_compte_eleves.php?id=<?php echo $ligne["ID"]; ?>"><img src="../assets/images/edit-white-icon.webp" alt="modifier" class="icons img-fluid"></a></button>
                                <button class="btn btn-sm btn-danger"><a href="supprimer_compte_eleves.php?id=<?php echo $ligne["ID"]; ?>"><img src="../assets/images/delete_icon_221152.png" alt="supprimer" class="icons img-fluid" onmouseover='src="../assets/images/delete_icon_open.png"' onmouseout='src="../assets/images/delete_icon_221152.png"' ></a></button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>