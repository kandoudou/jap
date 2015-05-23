<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
jap_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion sécurisée sur page protégée</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
            <p>Bienvenue <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
                Ceci est un exemple de page protégée. Pour avoir accès à cette page, vous devez 
être connecté. À un certain point, nous vérifions aussi le rôle de l’utilisateur, pour que les
 pages puissent connaître le type d’utilisateur autorisé à accéder à la page.
            </p>
            <p>Revenir à la <a href="login.php">page de connexion</a></p>
        <?php else : ?>
            <p>
                <span class="error">Vous n’avez pas les autorisations nécessaires pour accéder à cette page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>