<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css.css">
    <title>Connexion</title>
</head>
    <body>
        <form method="POST" action="back_end/connexion_back.php">
            <p>Identifiant</p>
                <input type="text" name="identifiant">
            <p>Mot de passe</p>
                <input type="password" name="password">
            <button type="submit" name="connexion">Connexion</button>
        </form>
    </body>
</html>