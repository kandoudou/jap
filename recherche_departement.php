<?php
include ('includes/function.php');
?>
<?php
include ('includes/db_connect.php');
include ('includes/functions.php');
include ('includes/db.php');
jap_session_start();
spl_autoload_register('autoload');
function autoload($class){
	require 'class/' . str_replace('\\', '/', $class) . '.php';
}
$tab_address = array();
$tab_ville = array();
$tab_name = array();
$tab_address_full = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans nom</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/infobubble.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php
if(isset($_POST["departement"]) && $_POST["departement"] != "" && $_POST["departement"] != 0 && isset($_POST["ville"]) && $_POST["ville"] != "" && $_POST["ville"] != 0)
	{
		$ville = $_POST["ville"];
// On récupère tout le contenu de la table jeux_video
$reponse = $pdo->query("SELECT * FROM `japonais_restaurants` WHERE `address_postal_code`='$ville'");

?>
<script type="text/javascript">
function initialiser() {
var options = [{
	center: new google.maps.LatLng(48.84673,2.271029),
}];
	
var map = new google.maps.Map(document.getElementById("carte"), options);
var bounds = new google.maps.LatLngBounds();
var styleArray = [
  {
    featureType: "all",
  },{
    featureType: "road.arterial",
    elementType: "geometry"
  },{
    featureType: "poi.business",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  }
];
map.setOptions({styles: styleArray});
var bounds = new google.maps.LatLngBounds();
<?php
$i=0;
while ($donnees = $reponse->fetch())
{
$i++;
$tab_address[] = $donnees['address_postal_code'];
$tab_ville[] = $donnees['address_city'];
$tab_name[] = $donnees['name'];
$tab_address_full[] = $donnees['address_full'];
?>
var prev_infobulle;
var marqueur_<?php echo $i; ?> = new google.maps.Marker({
		position: new google.maps.LatLng(<?php echo $donnees['location_lat']; ?>,<?php echo $donnees['location_long']; ?>),
		map: map
	});
google.maps.event.addListener(marqueur_<?php echo $i; ?>, 'click', function() {
var infobulle;
infobulle = new InfoBubble({
	map: map,
	content: "<?php echo addslashes($donnees['address_full']); ?>",
	position: new google.maps.LatLng(<?php echo $donnees['location_lat']; ?>,<?php echo $donnees['location_long']; ?>),
	shadowStyle: 0,  // Style de l'ombre de l'infobulle (0, 1 ou 2)
	padding: 10,  // Marge interne de l'infobulle (en px)
	backgroundColor: 'rgb(255,255,255)',  // Couleur de fond de l'infobulle
	borderRadius: 3, // Angle d'arrondis de la bordure
	arrowSize: 15, // Taille du pointeur sous l'infobulle
	borderWidth: 3,  // Épaisseur de la bordure (en px)
	borderColor: '#ffffff', // Couleur de la bordure
	disableAutoPan: true, // Désactiver l'adaptation automatique de l'infobulle
	arrowPosition: 50,  // Position du pointeur de l'infobulle (en %)
	arrowStyle: 0,  // Type de pointeur (0, 1 ou 2)
	disableAnimation: false,  // Déactiver l'animation à l'ouverture de l'infobulle
	minWidth :   150  // Largeur minimum de l'infobulle  (en px)
});
map.setCenter( new google.maps.LatLng(<?php echo $donnees['location_lat']; ?>,<?php echo $donnees['location_long']; ?>) );
if( prev_infobulle )
{
prev_infobulle.close();
}
//La précédent infobulle devient l'infobulle que l'on va ouvrir
prev_infobulle = infobulle;
 
//Enfin, on ouvre l'infobulle
infobulle.open();
});
bounds.extend(new google.maps.LatLng(<?php echo $donnees['location_lat']; ?>,<?php echo $donnees['location_long']; ?>));
<?php
}
?>
map.fitBounds(bounds);
}
</script>
</head>

<body onload="initialiser()">
		<div id="carte" style="height:300px; width:400px"></div>

<div id="restaurants">
<?php
foreach( $tab_ville as $index => $val ) {

?><?php

$departement = $tab_address[$index]; 
$ville = encode($tab_ville[$index]); 
$namerestaurant = $tab_name[$index];


?>

<p><a href="http://localhost/jap/jap/restaurant/<?php echo $departement[0],$departement[1]; ?>/<?php echo $ville; ?>/<?php echo encode($namerestaurant); ?>.html"><?php echo $namerestaurant; ?></a></p>
<p><?php echo $tab_address_full[$index]; ?>
</p>
<?php
}
$reponse->closeCursor(); // Termine le traitement de la requête		
}	    
?>
</div>
</body>
</html>