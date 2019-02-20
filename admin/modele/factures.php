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
    $requete = $this->database->prepare("SELECT factures.id, mail, tel, status, complement, date_creation, nom, prix FROM factures, items WHERE factures.id_items = items.id");

    $requete->execute();

    $resultat = $requete->fetchAll();

    return $resultat;
  }

  public function add($item, $mail, $tel, $complement) {
    error_log("ADD FACTURE");

    $query = "INSERT INTO factures (mail, tel, complement, id_items) VALUES ($mail, $tel, $complement, $item)";
    error_log($query);

    $requete = $this->database->prepare("INSERT INTO factures (mail, tel, complement, id_items)
                                         VALUES (:mail, :tel, :complement, :item)");

    $requete->bindParam(':mail', $mail, PDO::PARAM_STR);
    $requete->bindParam(':tel', $tel, PDO::PARAM_STR);
    $requete->bindParam(':complement', $complement, PDO::PARAM_STR);
    $requete->bindParam(':item', $item, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }
}

?>
