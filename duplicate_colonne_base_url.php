<?php  include ('includes/db.php');?>
<?php include('function.php'); ?>
<?php
// Cette page permet de dupliquer la colonne name, ville, département dans une nouvelle colonne pour former une nouvelle url

// On récupère tout le contenu de la table jeux_video
$reponse = $pdo->query('ALTER TABLE `japonais_restaurants` ADD `name_url` VARCHAR( 100 ) NOT NULL');
$reponse = $pdo->query('SELECT * FROM `japonais_restaurants`');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
<?php 
// retourne le code postal
$departement = $donnees['address_postal_code']; 
$ville = encode($donnees['address_city']); 
$namerestaurant = encode($donnees['name']);

$pdo->query("update `japonais_restaurants` set name_url ='".$departement[0].$departement[1].'/'.$ville.'/'.$namerestaurant."'"."WHERE id='".$donnees['id']."'");
}
?>