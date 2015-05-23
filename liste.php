<?php
	include ('includes/db.php');

	// On récupère tout le contenu de la table jeux_video
	$reponse = $pdo->query('SELECT * FROM `japonais_restaurants`');

	// On affiche chaque entrée une à une
	while ($donnees = $reponse->fetch()){ 
	// retourne le code postal
	$departement = $donnees['address_postal_code']; 
	$ville = encode($donnees['address_city']); 
	$namerestaurant = encode($donnees['name']);
?>
<p>
	<a href="http://localhost/jap/jap/restaurant/
		<?php echo $departement[0],$departement[1]; ?>/
		<?php echo $ville; ?>/
		<?php echo $namerestaurant; ?>
		.html"><?php echo $donnees['name']; ?>
	</a>
</p>
<p>
	<?php echo $donnees['address_full']; ?>
<?php
	}
	$reponse->closeCursor(); // Termine le traitement de la requête
?>