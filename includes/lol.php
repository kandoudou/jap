<?php
namespace Grafikart\Plugin;

    private $pdo;
    private $default = array(
        'username_error' => "Vous n'avez pas rentré de pseudo",
        'email_error' => "Votre email n'est pas valide",
        'content_error' => "Vous n'avez pas mis de message",
        'parent_error' => "Vous essazer de répondre à un commentaire qui n'existe pas"
    );

    public function __construct($pdo, $options = []) {
        $this->pdo = $pdo;
        $this->options = array_merge($this->default, $options);
    }
}