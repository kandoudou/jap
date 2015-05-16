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

// Récupère l'id de la page courante passée par l'URL
// Si non défini, on considère que la page est la page d'accueil
	if (isset($_GET['name'])) {
		$enva = $_ENV['name'] = strval($_GET['name']);
	} else {
		$_ENV['name'] = $id_page_accueil;
	}

// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query("SELECT * FROM `table 1` WHERE `name` ='$enva'");
// On affiche chaque entrée une à une

while ($donnees = $reponse->fetch())
{
$_ENV['name'] = $donnees['name'];
$_ENV['address_full'] = $donnees['address_full'];
$_ENV['phone_number'] = $donnees['phone_number'];
$_ENV['location_long'] = $donnees['location_long'];
$_ENV['location_lat'] = $donnees['location_lat'];
} 


$reponse->closeCursor(); // Termine le traitement de la requête


?>
<?php
//(1) On inclut la classe de Google Maps pour générer ensuite la carte.
require('GoogleMapAPI.class.php');

//(2) On crée une nouvelle carte; Ici, notre carte sera $map.
$map = new GoogleMapAPI('map');

//(3) On ajoute la clef de Google Maps.
$map->setAPIKey('AIzaSyCNjCLali0Bb5_VqETSmAH884sZT0gy2wE');
    
//(4) On ajoute les caractéristiques que l'on désire à notre carte.
$map->setWidth("400px");
$map->setHeight("300px");
$map->setCenterCoords (2.286682,48.877551);
$map->setZoomLevel (17);
$map->addMarkerByCoords( 2.286682, 48.877551, $_ENV['name'], "<em>contenu</em> de l'infobulle", $_ENV['name']);

//(5) On applique la base XHTML avec les fonctions à appliquer ainsi que le onload du body.
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<!-- Insère les mots-clés extraits de la DB dans les meta -->
<META NAME="keywords" lang="fr" CONTENT="">
<!-- Insère la description extraite de la DB dans les meta -->
<META NAME="Description" CONTENT="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- Insère le titre extrait de la DB dans la balise correspondante -->
<title><?php echo $_ENV['name']; ?></title>
<link rel="stylesheet" type="text/css" href="styles.css">
<?php $map->printHeaderJS(); ?>
		<?php $map->printMapJS(); ?>
</head>
<body onload="onLoad();">
<?php $map->printMap(); ?>
		<div id="contenu">
			
				<p><?php echo $_ENV['name']; ?></p>
				<p><?php echo $_ENV['address_full']; ?></p>
				<p><?php echo $_ENV['phone_number']; ?></p>

		</div>
	</div>
</body>
</html>