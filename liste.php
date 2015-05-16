<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=japonais;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query('SELECT * FROM `table 1`');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
<p><a href="http://localhost/jap/jap/page.php?name=<?php echo $donnees['name']; ?>"><?php echo $donnees['name']; ?></a></p>
<p><?php echo $donnees['address_name']; ?>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête
?>