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
$reponse = $bdd->query('SELECT * FROM `table 5`');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
<?php 
// retourne le code postal
$departement = $donnees['address_postal_code']; 
$ville = encode($donnees['address_city']); 
$namerestaurant = encode($donnees['name']);
?>
<p><a href="http://localhost/jap/jap/restaurant/<?php echo $departement[0],$departement[1]; ?>/<?php echo $ville; ?>/<?php echo $namerestaurant; ?>.html"><?php echo $donnees['name']; ?></a></p>
<p><?php echo $donnees['address_full']; ?>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête
?>