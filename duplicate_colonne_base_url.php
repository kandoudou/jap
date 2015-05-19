<?php 

// Cette page permet de dupliquer la colonne name, ville, département dans une nouvelle colonne pour former une nouvelle url 

?>
<?php include('function.php'); ?>
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
$reponse = $bdd->query('ALTER TABLE `table 5` ADD `name_url` VARCHAR( 100 ) NOT NULL');
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

$bdd->query("update `table 5` set name_url ='".$departement[0].$departement[1].'/'.$ville.'/'.$namerestaurant."'"."WHERE id='".$donnees['id']."'");
}
?>