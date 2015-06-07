<!doctype html>
<html class="no-js" lang="">
  <head>
  <title></title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
        $("#departement").change(function() {
        $("select#departement option:selected").each(function() {
            if($(this).val() != 0) {
                var request = $.ajax({
                  url: "includes/function.php",
                  method: "POST",
                  data: { val_dep_ajax : $(this).val(), val_dep_function_ajax: 'moteur_de_recherche_ville' },
                  dataType: "html"
                });   
               request.done(function(msg) {
                  $("select#ville").html(msg);
                });
            }
          else {
                $("select#ville").html("<option value='0'>Séclionnez en premier lieu un département</option>");
            }
        });
        });
        })
        </script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
  </head>
  <body onload="initialize()">
<?php
	
include ('includes/db.php');
include ('includes/function.php');
include ('includes/form_departement_classement.php');

  
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</body>
</html>
