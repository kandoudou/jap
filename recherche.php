<?php
include ('includes/function.php');
include ('includes/db.php');

if($_POST["envoi"] && $_POST["address_postal_code"] !== 0 && $_POST["address_city"] !== 0 )
	{
		$question 	= $_POST["address_postal_code"];
		$questions 	= $_POST["address_city"];
// On récupère tout le contenu de la table jeux_video
$reponse = $pdo->query("SELECT * FROM `japonais_restaurants` WHERE `address_city`='$questions'");

	// Execute the query (the recordset $rs contains the result)

	// Loop the recordset $rs
	// Each row will be made into an array ($row) using mysql_fetch_array
	// On affiche chaque entrée une à une

while ($donnees = $reponse->fetch())
{
?><?php
$departement = $donnees['address_postal_code']; 
$ville = encode($donnees['address_city']); 
$namerestaurant = encode($donnees['name']);
?>
<p><a href="http://localhost/jap/jap/restaurant/<?php echo $departement[0],$departement[1]; ?>/<?php echo $ville; ?>/<?php echo $namerestaurant; ?>.html"><?php echo $donnees['name']; ?></a></p>
<p><?php echo $donnees['address_full']; ?>
<?php
}


$reponse->closeCursor(); // Termine le traitement de la requête7
		
		
	}	    
?>