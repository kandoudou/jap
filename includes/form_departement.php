<?php
include ('db.php');

// On récupère tout le contenu de la table jeux_video
$reponse = $pdo->query('SELECT address_postal_code FROM `japonais_restaurants` ORDER BY address_postal_code ASC ');
?>
<br/><br/>
<form action="recherche_departement.php" method="post" id="moteurdepartment">
<select id="departement" name="departement">

<?php
// On affiche chaque entrée une à une
$donnees_departements = array(); // création de mon tableau dep
$donnees_departements_count = array(); // comptage nombre de ville par dep
while ($donnees = $reponse->fetch())
{
?>

<?php 
	// retourne le code postal
	if ($donnees['address_postal_code'] != "") {
		$departement = $donnees['address_postal_code']; 
		$donnees_departements[$departement[0].$departement[1]] = $departement[0].$departement[1]; 
		$donnees_departements_count[] = $departement[0].$departement[1]; 
	}
}

$reponsedep = $pdo->query('SELECT departement_code,departement_nom FROM `departement` ORDER BY departement_nom ASC ');

$occurences = array_count_values($donnees_departements_count);
?>

<option value="0" selected="selected">S&eacute;lectionnez un d&eacute;partement</option>

<?php
while ($donneesdep = $reponsedep->fetch())
{
	if(array_key_exists($donneesdep['departement_code'],$donnees_departements)) {
?>
		<option value="<?php echo $donneesdep['departement_code']; ?>"><?php echo $donneesdep['departement_nom']; ?> (<?php echo $occurences[$donneesdep['departement_code']];?>)</option>
<?php
	}
}
?>

</select>
<select id="ville" name="ville">
	<option value="0">S&eacute;clionnez en premier lieu un d&eacute;partement</option>
</select>
<br/><br/>
<input type="submit" id="button_recherche_dep" name="envoi" value="ok"/> 
<?php
$reponse->closeCursor(); // Termine le traitement de la requête
$reponsedep->closeCursor(); // Termine le traitement de la requête
?>

</form>