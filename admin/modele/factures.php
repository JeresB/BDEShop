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
    $requete = $this->database->prepare("SELECT id, mail, tel, status, complement, date_creation, contenu FROM factures ORDER BY id");

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
    $contenu = json_encode($contenu);
    $requete = $this->database->prepare("INSERT INTO factures (mail, tel, complement, contenu)
                                         VALUES (:mail, :tel, :complement, :contenu)");

    $requete->bindParam(':mail', $mail, PDO::PARAM_STR);
    $requete->bindParam(':tel', $tel, PDO::PARAM_STR);
    $requete->bindParam(':complement', $complement, PDO::PARAM_STR);
    $requete->bindParam(':contenu', $contenu);

    $resultat = $requete->execute();

    $order_ref = $this->database->lastInsertId();

    return $order_ref;
  }

  public function updateStatus($order_ref, $status) {
    $requete = $this->database->prepare("UPDATE factures
                                         SET status = :status
                                         WHERE id = :id");
    $requete->bindParam(':status', $status, PDO::PARAM_STR);
    $requete->bindParam(':id', $order_ref, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function getEmail($order_ref) {
    $requete = $this->database->prepare("SELECT mail FROM factures WHERE id = :order_ref");
    $requete->bindParam(':order_ref', $order_ref, PDO::PARAM_STR);

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }
}

?>
