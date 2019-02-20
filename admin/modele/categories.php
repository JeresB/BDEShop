<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/bdd/bdd_var.php");

class BDD_CATEGORIES {

  private $database = null;

  function __construct() {
    try {
      $this->database = new PDO('mysql:host='.BDD_HOST.';dbname='.BDD_NAME.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    } catch (Exception $e) {
      print "[BDD_ERROR] : " . $e->getMessage() . "<br/>";
      die();
    }
  }

  public function list() {
    $requete = $this->database->prepare("SELECT * FROM categories");

    $requete->execute();

    $resultat = $requete->fetchAll();

    return $resultat;
  }

  public function count() {
    $requete = $this->database->prepare("SELECT count(id) as nb FROM categories");

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function delete($id) {
    $requete = $this->database->prepare("DELETE FROM categories WHERE id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function add($nom) {
    $requete = $this->database->prepare("INSERT INTO categories (nom) VALUES (:nom)");
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);

    $resultat = $requete->execute();

    return $resultat;
  }
}

?>
