<?php 
// Inclusion du fichier de connexion à la base de données
require ('..\back_end\connexion_admin.php');
require ('..\back_end\id_verif_admin_autres.php');
?>
<html>
        <head>
        
            <title>Compte autres</title>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="author" content="Timothe Pellen">
            <meta name="description" content="Page de création de compte autre"> 
            
            <meta name="keywords" content="BTS SIO, BTS SIO SISR, BTS SIO SLAM, métiers informatique, administrateur réseau, développeur web, technicien support, analyste de données, jeux vidéo, cybersécurité, cloud computing, gestion de projet informatique, consultant IT, ingénieur logiciel, architecte réseau, spécialiste en sécurité informatique">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
            <link rel="stylesheet" href="../assets/css/formulaire.css">
        </head>
        <?php
            include 'nav_admin.php';
        ?>
        <body>
            <form action="../back_end/post_modifier_compte_autres.php?id=<?= $_GET['id'] ?? '' ?>" method="post" class="form">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="form col-3">
                        <label class="row" for="nom">Entrez votre nom&nbsp;: </label>
                        <input class="row" type="text" name="nom" id="nom" value="<?= $article['nom'] ?? '' ?>" required />
                    </div>
                    <div class="col-2"></div>
                    <div class="form col-3">
                        <label class="row" for="prenom">Entrez votre prenom&nbsp;: </label>
                        <input class="row" type="text" name="prenom" id="prenom" value="<?= $article['prenom'] ?? '' ?>" required />
                    </div>
                    <div class="col-2"></div>
                    <div class="col-2"></div>
                    <div class="form col-3">
                        <label class="row" for="phone">Entrez votre numéro de telephone&nbsp;: </label>
                        <input class="row" type="tel" name="phone" id="phone" pattern="0{1}[0-9]{9}" value="<?= $article['tel'] ?? '' ?>" required />
                    </div>
                    <div class="col-2"></div>
                    <div class="form col-3">
                        <?php $nonce = hex2bin("6829f4813216c73bd71d92758943fe5d2d76ef1611072842");
                        $cle_secrete = hex2bin("ada74470449cb6ca929713d3e97313f86f3b0f2783f3937a024bb04b7c9fb311");
                        $texte_chiffre = $article['emel_chiffr'];
                        $message_dechiffre = sodium_crypto_secretbox_open($texte_chiffre, $nonce, $cle_secrete); ?>
                        <label class="row" for="emel">Entrez votre Adresse Email&nbsp;: </label>
                        <input class="row" type="email" name="emel" id="emel" value="<?= $message_dechiffre ?? '' ?>" required />
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5"></div>
                    <div class="form col-2">
                        <label class="row" for="statut">Entrez votre Status&nbsp;: </label>
                        <select id="statut-select" name="statut" default="<?= $article['libelle'] ?? '' ?>">
                            <option>--Veuillez choisir une option--</option>
                            <?php
                            // Récupération des articles de la catégorie actuelle
                            $requete = $connexion->prepare('SELECT * from statut');
                            $requete->execute();
                            $lignes = $requete->fetchAll();

                            // Boucle sur chaque article de la catégorie
                            foreach($lignes as $ligne)  
                            {
                            ?>
                                <option value="<?= $ligne['ID'] ?>" <?= ($article['libelle'] ?? '') === $ligne['libelle'] ? 'selected' : '' ?>><?= $ligne['libelle'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-5"></div>
                    <div class="col-12"> <p></p></div>
                    <div class="col-5"></div>
                    <div class="col-2">
                        <input type="submit" value="Valider"/>
                    </div>
                    <div class="col-5"></div>
                </div>
            </form>
        </body>