<?php
include_once 'functions.php';
jap_session_start();
 
// Détruisez les variables de session 
$_SESSION = array();
 
// Retournez les paramètres de session 
$params = session_get_cookie_params();
 
// Effacez le cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Détruisez la session 
session_destroy();
header('Location: ../index.php');
exit;