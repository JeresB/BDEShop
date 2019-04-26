<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/bdd/bdd_var.php");

class BDD_TRANSACTIONS {

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
    $requete = $this->database->prepare("SELECT count(id) as nb FROM transaction_billetterie");

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function countWithID($id) {
    $requete = $this->database->prepare("SELECT count(id) as nb FROM transaction_billetterie WHERE id_Billetterie = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function listAll() {
    $requete = $this->database->prepare("SELECT * FROM transaction_billetterie ORDER BY id");

    $requete->execute();

    $resultat = $requete->fetchAll();

    return $resultat;
  }

  public function list($id_billetterie) {
    $requete = $this->database->prepare("SELECT * FROM transaction_billetterie WHERE id_Billetterie = :id ORDER BY id");

    $requete->bindParam(':id', $id_billetterie, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetchAll();

    return $resultat;
  }

  public function get($id) {
    $requete = $this->database->prepare("SELECT * FROM transaction_billetterie WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function delete($id) {
    $requete = $this->database->prepare("DELETE FROM billetteries WHERE id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function add($mail, $tel, $place, $horaire, $nom, $prenom, $promo, $code_promo, $infos_utile, $id_billetterie) {
    $status = 'En attente de confirmation de payement de Lydia';

    $requete = $this->database->prepare("INSERT INTO transaction_billetterie (id_Billetterie, tel, mail, nom, prenom, promo, place, horaire, code_promo, infos_utile, status)
                                         VALUES (:id, :tel, :mail, :nom, :prenom, :promo, :place, :horaire, :code_promo, :infos_utile, :status)");

    $requete->bindParam(':id', $id_billetterie, PDO::PARAM_INT);
    $requete->bindParam(':tel', $tel, PDO::PARAM_STR);
    $requete->bindParam(':mail', $mail, PDO::PARAM_STR);
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $requete->bindParam(':promo', $promo, PDO::PARAM_STR);
    $requete->bindParam(':place', $place, PDO::PARAM_STR);
    $requete->bindParam(':horaire', $horaire, PDO::PARAM_STR);
    $requete->bindParam(':code_promo', $code_promo, PDO::PARAM_STR);
    $requete->bindParam(':infos_utile', $infos_utile, PDO::PARAM_STR);
    $requete->bindParam(':status', $status, PDO::PARAM_STR);

    $resultat = $requete->execute();

    $order_ref = $this->database->lastInsertId();

    return $order_ref;
  }

  public function update($id, $tel, $mail, $nom, $prenom, $promo, $type_place, $horaire, $code_promo, $infos_utile, $status) {
    $requete = $this->database->prepare("UPDATE transaction_billetterie
                                         SET tel = :tel, mail = :mail, nom = :nom, prenom = :prenom, promo = :promo, place = :place, horaire = :horaire, code_promo = :code_promo, infos_utile = :infos_utile, status = :status
                                         WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':tel', $tel, PDO::PARAM_STR);
    $requete->bindParam(':mail', $mail, PDO::PARAM_STR);
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $requete->bindParam(':promo', $promo, PDO::PARAM_STR);
    $requete->bindParam(':place', $type_place, PDO::PARAM_STR);
    $requete->bindParam(':horaire', $horaire, PDO::PARAM_STR);
    $requete->bindParam(':code_promo', $code_promo, PDO::PARAM_STR);
    $requete->bindParam(':infos_utile', $infos_utile, PDO::PARAM_STR);
    $requete->bindParam(':status', $status, PDO::PARAM_STR);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function updateStatus($order_ref, $status) {
    $requete = $this->database->prepare("UPDATE transaction_billetterie
                                         SET status = :status
                                         WHERE id = :id");
    $requete->bindParam(':status', $status, PDO::PARAM_STR);
    $requete->bindParam(':id', $order_ref, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function getEmail($order_ref) {
    $requete = $this->database->prepare("SELECT mail FROM transaction_billetterie WHERE id = :order_ref");
    $requete->bindParam(':order_ref', $order_ref, PDO::PARAM_STR);

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }
}

?>
