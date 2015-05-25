<?php

//Liste toute les fonctions utilisées sur le site

if(isset($_POST['val_dep_function_ajax'])) {
$fonction = $_POST['val_dep_function_ajax'];
unset($_POST['val_dep_function_ajax']);
$fonction($_POST);
}
function encode($chaine) {
    
    $chaine = trim($chaine);
 
    $chaine = htmlentities($chaine, ENT_NOQUOTES, 'UTF-8');
 
    $patterns = array(
        /* lettres speciales : 'é' => 'e', 'ç' => 'c' */
        '#&([A-Za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#',
 
        /* ligatures : 'œ' => 'oe' */
        '#&([A-Za-z]{2})(?:lig);#',
 
        /* caracteres speciaux restant : '&' => '', '?' => '' */
        '#&[^;]+;#',
        '#([^a-z0-9/]+)#i',
    );
 
    $remplacements = array(
        '\1',
        '\1',
        '',
        '-',
    );
 
    $chaine = preg_replace($patterns, $remplacements, $chaine);
    $chaine = strtolower($chaine);
 
    return $chaine;
}

function moteur_de_recherche_ville() {
$id = $_POST['val_dep_ajax'];
include ('db.php');
if ($id != 75) {
$reponse = $pdo->query("SELECT address_city,address_postal_code FROM `japonais_restaurants` WHERE address_postal_code LIKE '$id%' ORDER BY address_city ASC");
}
else {
$reponse = $pdo->query("SELECT address_city,address_postal_code FROM `japonais_restaurants` WHERE address_postal_code LIKE '$id%' ORDER BY address_postal_code ASC");	
}

$donnees_villes = array(); // création de mon tableau dep
$donnees_villes_count = array(); // comptage nombre de ville par dep
while ($donnees = $reponse->fetch())
{
?>

<?php 
	$donnees_villes[$donnees["address_postal_code"]] = $donnees["address_city"]; 
	$donnees_villes_count[] = $donnees["address_postal_code"]; 
	
}
$occurences = array_count_values($donnees_villes_count);
foreach ($donnees_villes as $key => $value){
?>
<?php 

	if ($key >= 75000 & $key <= 75020) {
		$ville = substr($value, 0);
		$arrondissement = substr($key, -2);
?>
		<option value="<?php echo $key; ?>"><?php echo $ville[0].$ville[1].$ville[2].$ville[3].$ville[4]." ".$arrondissement; ?> (<?php echo $occurences[$key];?>)</option>
        
<?php
	}
	else {
?>	

		<option value="<?php echo $key; ?>"><?php echo $value; ?> (<?php echo $occurences[$key];?>)</option>

<?php
	}
}

$reponse->closeCursor(); // Termine le traitement de la requête

}
