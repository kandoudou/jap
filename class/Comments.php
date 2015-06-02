<?php
 /**
 * Class Commentaire / notation permet d'afficher un systeme de commentaire pour chaque restaurant
 */
 class Comments
 {
 	private $pdo;
 	private $options = array(
 		'user_id_error' => "Vous devez vous connecter",
 		'email_error' => "Votre email n'est pas valide",
 		'content_error' => "Vous n'avez pas mis de message"
 		);
 	public $errors = array();

 	public function __construct($pdo, $options = [])
 	{
 		$this->pdo = $pdo;
 		$this->options = array_merge($this->options, $options);
 	}

 	/**
 	* PERMET DE RECUPERER LES COMMENTAIRES ASSOCIE A UN CONTENU
 	**/
 	public function findAll($ref, $ref_id){
 		$q = $this->pdo-> prepare("SELECT * FROM japonais_comments WHERE ref_id = :ref_id AND ref= :ref ORDER BY created DESC");
		$q->execute(['ref' => $ref,'ref_id' => $ref_id]);
		return $q->fetchAll();
 	}

 	/**
 	* PERMET DE SAUVEGARGER UN COMMENTAIRE
 	**/

 	public function save($ref, $ref_id)
 	{	
 		$errors = [];
	 	if (!isset($_SESSION['username'])) {
	 		$errors['user_id'] = $this->options['user_id_error'];
	 			
	 	}

	 	//if (
	 	//	empty($_POST['email']) || 
	 	//	!filter_var($_POST['email']. FILTER_VALIDATE_EMAIL)) {
	 	//	$errors['email'] = $this->options['email_error'];
	 	//}
 		
 		if (empty($_POST['content'])) {
 			$errors['content'] = $this->options['content_error'];
 			
 		}
 		if (empty($_POST['note1'])) {
 			$errors['note1'] = $this->options['note_error'];
 			
 		}
 		if (empty($_POST['note2'])) {
 			$errors['note2'] = $this->options['note_error'];
 			
 		}
 		if (count($errors) > 0) {
 			$this->errors = $errors ;
 			return false;
 		}
 		$q = $this->pdo->prepare('INSERT INTO japonais_comments SET user_id = :user_id, note1= :note1, note2= :note2, username= :username, content = :content, ref_id = :ref_id, ref = :ref, created = :created');
 		$data = [
		'user_id' => $_SESSION['user_id'],
		'username' => $_SESSION['username'],
		'content' => $_POST['content'],
		'note1' => $_POST['note1'],
		'note2' =>$_POST['note2'],
		'ref_id' => $ref_id,
		'ref' => $ref,
		'created' => date('Y-m-d H:i:s'),
 		];
 		return $q->execute($data);
 	}
 }
?>
