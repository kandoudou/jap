<?php
	
	include ('includes/db.php');

	// On récupère tout le contenu de la table



	$reponse = $pdo->query('SELECT japonais_restaurants.name, AVG((note1+note2)/2) AS moyenne FROM `japonais_restaurants` LEFT JOIN `japonais_comments` ON japonais_restaurants.id = japonais_comments.ref_id GROUP BY japonais_restaurants.id ORDER BY moyenne  DESC LIMIT 20');
	$rank = 1;
	// On affiche chaque entrée une à une
	while ($donnees = $reponse->fetch()){ 

	// retourne le code postal
	$namerestaurant = $donnees['name'];
	$note = $donnees['moyenne'];
	$rankfinale = $rank ++;

?>
<p>
	<?php echo $rankfinale; ?>
	<?php echo $donnees['name']; ?>
	<?php echo $donnees['moyenne']; ?>
	</a>
</p>
<p>
	
<?php
	}
	$reponse->closeCursor(); // Termine le traitement de la requête
?>