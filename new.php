<?php
$api_key = 'AIzaSyD-SpFE2pLQolFLCliMgVgHG2NAq8mG3fY';
// AIzaSyC8N-xWZVPqMHL2zl4HW2EV-P1Qx1xyTLM @jeremie.kandoudaeff
// AIzaSyBZGcy1ZP1ESi33SIraHfx-coKwxAke5X4
// AIzaSyAWQ-9JBH3RGx6s_5Ifb4qkkS_jIqf5u7M @kanpoubelle
// AIzaSyCeTmvQweIttk63aspxKPCj_voijnOO61Q @kanpoubelles
// AIzaSyDgxMn-7k82C3gAgR86kSbfVWOo-k2PQIc @kanpoubeaux
// AIzaSyD-SpFE2pLQolFLCliMgVgHG2NAq8mG3fY
// AIzaSyBWqu64qvWnn34FXPdozyAxtISu0xmHBZ8 @plomberieao
$cp = '95860';
$json_string = file_get_contents('https://maps.googleapis.com/maps/api/place/textsearch/json?language=fr&query=japonais+in+france%20'."$cp".'&key='."$api_key");
$parsed_json = json_decode($json_string);
try
{
	$pdo = new PDO('mysql:host=localhost;dbname=japonais;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	foreach ($parsed_json->{'results'} as $weekday){
		echo $weekday->{'place_id'}.'<br>';
		$myText = print_r($weekday->{'place_id'},true);
		$query = "INSERT INTO `place`(`id`) VALUES ('$myText')";
		$pdo->exec($query);
	}	
		
	$token = $parsed_json->{'next_page_token'};
		$url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?language=fr&query=japonais+in+france%20'."$cp".'&key='."$api_key".'&pagetoken='."$token";
		sleep(3);
		$json_string1 = file_get_contents($url);
		echo '<br>'.'<br>';
		$parsed_json1 = json_decode($json_string1);
		foreach ($parsed_json1->{'results'} as $weekday1){
			echo $weekday1->{'place_id'}.'<br>';
			$myText1 = print_r($weekday1->{'place_id'},true);
			$query1 = "INSERT INTO `place`(`id`) VALUES ('$myText1')";
			$pdo->exec($query1);
			}
		
		$token2 = $parsed_json1->{'next_page_token'};
		$url2 = 'https://maps.googleapis.com/maps/api/place/textsearch/json?language=fr&query=japonais+in+france%20'."$cp".'&key='."$api_key".'&pagetoken='."$token2";
		sleep(3);
		$json_string2 = file_get_contents($url2);
		echo '<br>'.'<br>';
		$parsed_json2 = json_decode($json_string2);
		foreach ($parsed_json2->{'results'} as $weekday2){
			echo $weekday2->{'place_id'}.'<br>';
			$myText2 = print_r($weekday2->{'place_id'},true);
			$query2 = "INSERT INTO `place`(`id`) VALUES ('$myText2')";
			$pdo->exec($query2);
			}	

		
	
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
	die('Erreur : '.$e->getMessage());
}



?>