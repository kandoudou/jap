<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
use App\Facebook\FacebookConnect; 
require 'vendor/autoload.php';

jap_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Connexion sécurisée, page de connexion</title>
        <link rel="stylesheet" href="styles/main.css" />
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Une erreur s’est produite lors de votre connexion!</p>';
        }
        ?> 
        <form action="includes/process_login.php" method="post" name="login_form">                      
            Email: <input type="text" name="email" />
            Password: <input type="password" 
                             name="password" 
                             id="password"/>
            <input type="button" 
                   value="Connexion" 
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>
        <p>Si vous n’avez pas de compte, veuillez vous <a href="register.php">enregistrer</a></p>
<?php 
$connect = new FacebookConnect ('1610337399213758', '6765e0c08e4bf83be4fdf4c5bdad71bc');
$user = $connect->connect('http://localhost/jap/jap/login.php');
if(is_string($user)){
    echo "<a href='$user'>Se Connecter avec Facebook</a>";
}else{
$insert_stmt = $mysqli->prepare("INSERT INTO members (id, username, email) VALUES (?, ?, ?)");
$id = $user->getId();
$username = $user->getLastName();
$email = $user->getEmail();
            $insert_stmt->bind_param('sss', $id, $username, $email);
            // Exécute la déclaration.
            if (! $insert_stmt->execute()) {
                
                echo "Bienvenue ". $username = $user->getFirstName();
            }
        }
    
?>
        <p>Si vous avez terminé, veuillez vous <a href="includes/logout.php">déconnecter</a>.</p>
        <p>Vous êtes connecté <?php echo $logged ?>.</p>
    </body>
</html>