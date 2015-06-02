<?php
/*************************/
/***** Connexion PDO *****/
/*************************/

// Constantes
define("HOST","localhost", true);
define("USER","japonais_user", true);
define("PASS","E5eBs4NgR6CPMvCxbhrgrjsn", true);

// Bases de données
define("DATABASE", "japonais", true);

// Define class
class DB
{
     private static $sql = NULL;

     public static function getInstance() {

         if (!self::$sql) {
             self::$sql = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
             self::$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         }
         return self::$sql;
     }

     // interdiction de cloner l'instance
     private function __clone() {
     }
}

?>