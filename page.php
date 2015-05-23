<?php
include ('includes/db_connect.php');
include ('includes/functions.php');
include ('includes/db.php');
jap_session_start();
spl_autoload_register('autoload');
function autoload($class){
	require 'class/' . str_replace('\\', '/', $class) . '.php';
}
// Récupère l'id de la page courante passée par l'URL
// Si non défini, on considère que la page est la page d'accueil
	if (isset($_GET['name'])) {
		$enva = $_ENV['name'] = $_GET['departement'].'/'.$_GET['ville'].'/'.$_GET['name'];
	} else {
		$_ENV['name'] = $id_page_accueil;
	}

// On récupère tout le contenu de la table jeux_video
$reponsecount = $pdo->query("SELECT * FROM `japonais_restaurants` WHERE `name_url`='$enva'");

//Permet de rediriger l'utilisateur sur la page 404 si la page n'existe pas
if ($reponsecount->fetchColumn() == 0) {
header('Location:http://'.$_SERVER['HTTP_HOST'].'/jap/jap/404.html');
}

$reponse = $pdo->query("SELECT * FROM `japonais_restaurants` WHERE `name_url`='$enva'");

// On affiche lle restaurant
while ($donnees = $reponse->fetch())
{
$_ENV['name'] = $donnees['name'];
$_ENV['id'] = $donnees['id'];
$_ENV['address_full'] = $donnees['address_full'];
$_ENV['phone_number'] = $donnees['phone_number'];
$_ENV['location_long'] = $donnees['location_long'];
$_ENV['location_lat'] = $donnees['location_lat'];
} 


$reponse->closeCursor(); // Termine le traitement de la requête


//(1) On inclut la classe de Google Maps pour générer ensuite la carte.
require('GoogleMapAPI.class.php');

//(2) On crée une nouvelle carte; Ici, notre carte sera $map.
$map = new GoogleMapAPI('map');

//(3) On ajoute la clef de Google Maps.
$map->setAPIKey('AIzaSyCNjCLali0Bb5_VqETSmAH884sZT0gy2wE');
    
//(4) On ajoute les caractéristiques que l'on désire à notre carte.
$map->setWidth("400px");
$map->setHeight("300px");
$map->setCenterCoords ($_ENV['location_long'],$_ENV['location_lat']);
$map->setZoomLevel (17);
$map->addMarkerByCoords( $_ENV['location_long'], $_ENV['location_lat'], $_ENV['name'], "<em>contenu</em> de l'infobulle", $_ENV['name']);

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
		<?php
		$comments_cls = new Comments($pdo);
		//SOUMISSION DUN COMMENTAIRE
		$errors = false;
		$success = false;
		if (isset($_POST['action']) && $_POST['action'] == 'comment') {
			$save = $comments_cls->save('japonais_restaurants', $_ENV['id']);
			if ($save) {
				$success = true;
			}else{$errors = $comments_cls->errors;}
		}
		
		$comments =$comments_cls->findAll('japonais_restaurants', $_ENV['id']);
		
		?>

		<h2><?= count($comments); ?> Commentaires</h2>
		<?php if ($errors): ?>
		<div class="alert alert-danger">
			<strong>Impossible de poster votre commentaire</strong> pour les raisons suivantes :
			<ul>
				<?php foreach ($errors as $error): ?>
					<li><?= $error; ?></li>
				<?php endforeach ?>
				
			</ul>
		</div>
	<?php endif ?>
			<?php if ($success): ?>
		<div class="alert alert-success">
			<strong>CLAP CLAP !!!</strong> votre commentaire a bien été posté 
		</div>
	<?php endif ?>
		<form action="#comment" role="form" method="post" id="comment">
			<div class="row">
				<div class="col-xs-6">

				</div>
				<div class="col-xs-6">
				</div>
				<div class="col-xs-12">
					<div class="form-group">
						<label>Commentaire</label>
						<textarea class="form-control" name="content"></textarea>
					</div>
				</div>
				<button type="submit" name="envoyer">Envoyer</button>
			</div>
			<input type="hidden" name="action" value="comment">
		</form>

		<?php foreach ($comments as $comment): ?>
			<div class="comment row" style="border:solid 1px #DDD">
				<div class="col-s-2">
					<img src="http://www.gravatar.com/avatar/<?= md5($comment['email']); ?>">
				</div>
				<div class="col-s-10">
				<p>
					<strong><?= $comment['username']; ?>,</strong>
					<em><?= date('d/m/Y', strtotime($comment['created'])); ?></em>
				</p>
				<p>
					<?= $comment['content']; ?>
				</p>
				</div>
			</div>
	<?php endforeach ?>
</body>
</html>