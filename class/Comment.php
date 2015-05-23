<?php
 /**
 * Class Commentaire / notation permet d'afficher un systeme de commentaire pour chaque restaurant
 */
 class Comments
 {
 	private $bdd;

 	public function __construct($bdd)
 	{
 		$this->pdo = $bdd;
 	}

 	public function findAll($ref, $ref_id){
 		$q = $bdd -> prepare("SELECT * FROM japonais_comments WHERE ref_id = {$_ENV['id']} AND ref='japonais_restaurants' ORDER BY created DESC");
		$q->execute(['ref'->$ref,'ref_id'->$ref_id]);
		return $q->fetchAll();
 	}
 }
?>
