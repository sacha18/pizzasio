<?php
// Singleton pour connecter au bd.
class Bdd {
  // Gardez l'instance de classe.
  private static $instance = null;
  private $conn;
   
  // La connexion au bd est établie dans le constructeur privé.
  private function __construct()
  {
    $this->conn = new PDO('mysql:host=localhost;dbname=' . NOM_BDD, LOGIN_BDD, PASSWORD_BDD);
  }
  
  public static function getInstance()
  {
    if(!self::$instance)
    {
      self::$instance = new Bdd();
    }
   
    return self::$instance;
  }
  
  public function getConnection()
  {
    return $this->conn;
  }
}
?>