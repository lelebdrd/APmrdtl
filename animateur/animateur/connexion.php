<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Animateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-container">
        <h1>Connexion</h1>

        <form action="connexion_back.php" method="post">
            <div class="form-group">
                <p for="identifiant">identifiant</p>
                <input type="text"  name="identifiant" required>
            </div>

            <div class="form-group">
                <p for="Mot de passe">Mot de passe</p>
                <input type="Mot de passe" name="Mot_de_passe" required>
            </div>

            <button type="submit">Se connecter</button>
        </form>
    </div>


</body>
</html>
