<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans nom</title>
</head>

<body>
<?php 
include ('includes/function.php');
include ('includes/db.php');
?>
<?php
if(isset($_POST["departement"]) && $_POST["departement"] != "" && $_POST["departement"] != 0 && isset($_POST["ville"]) && $_POST["ville"] != "" && $_POST["ville"] != 0)
	{
		$ville = $_POST["ville"];
// On récupère tout le contenu de la table jeux_video
$reponse = $pdo->query("SELECT japonais_restaurants.name,japonais_restaurants.address_postal_code,japonais_restaurants.address_city,japonais_restaurants.address_full, AVG((note1+note2)/2) AS moyenne FROM `japonais_restaurants` LEFT JOIN `japonais_comments` ON japonais_restaurants.id = japonais_comments.ref_id WHERE `address_postal_code`='$ville' GROUP BY japonais_restaurants.id ORDER BY moyenne  DESC LIMIT 20");
$rank = 1;
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
$note = $donnees['moyenne'];
$rankfinale = $rank ++;
?>
<?php echo $rankfinale; ?> - 
<a href="http://localhost/jap/jap/restaurant/<?php echo $departement[0],$departement[1]; ?>/<?php echo $ville; ?>/<?php echo $namerestaurant; ?>.html"><?php echo $donnees['name']; ?></a>
<p><?php echo $donnees['address_full']; ?></p>
<p>Note : <?php echo $donnees['moyenne']; ?></p>
<?php
}
$reponse->closeCursor(); // Termine le traitement de la requête7
		
		
	}	    
?>
</body>
</html>