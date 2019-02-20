<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/bdd/bdd_var.php");

class BDD {

  private $database = null;

  function __construct() {
    try {
      $this->database = new PDO('mysql:host='.BDD_HOST.';dbname='.BDD_NAME.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    } catch (Exception $e) {
      print "[BDD_ERROR] : " . $e->getMessage() . "<br/>";
      die();
    }
  }

  public function connexion($login, $pass) {
    $requete = $this->database->prepare("SELECT * FROM admin WHERE login = :login AND pass = :pass");
    $requete->bindParam(':login', $login, PDO::PARAM_STR);
    $requete->bindParam(':pass', $pass, PDO::PARAM_STR);

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }
}

?>
