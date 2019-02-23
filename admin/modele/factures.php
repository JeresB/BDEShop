<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/bdd/bdd_var.php");

class BDD_FACTURES {

  private $database = null;

  function __construct() {
    try {
      $this->database = new PDO('mysql:host='.BDD_HOST.';dbname='.BDD_NAME.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    } catch (Exception $e) {
      print "[BDD_ERROR] : " . $e->getMessage() . "<br/>";
      die();
    }
  }

  public function count() {
    $requete = $this->database->prepare("SELECT count(id) as nb FROM factures");

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function list() {
    $requete = $this->database->prepare("SELECT id, mail, tel, status, complement, date_creation FROM factures");

    $requete->execute();

    $resultat = $requete->fetchAll();

    return $resultat;
  }

  public function get($id) {
    $requete = $this->database->prepare("SELECT id, mail, tel, status, complement, date_creation, contenu FROM factures WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function add($mail, $tel, $complement, $contenu) {
    error_log("ADD FACTURE");

    //$query = "INSERT INTO factures (mail, tel, complement, contenu) VALUES ($mail, $tel, $complement, $contenu)";
    //error_log($query);

    $requete = $this->database->prepare("INSERT INTO factures (mail, tel, complement, contenu)
                                         VALUES (:mail, :tel, :complement, :contenu)");

    $requete->bindParam(':mail', $mail, PDO::PARAM_STR);
    $requete->bindParam(':tel', $tel, PDO::PARAM_STR);
    $requete->bindParam(':complement', $complement, PDO::PARAM_STR);
    $requete->bindParam(':contenu', json_encode($contenu));

    $resultat = $requete->execute();

    return $resultat;
  }
}

?>
