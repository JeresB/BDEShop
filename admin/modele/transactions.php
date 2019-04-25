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
    $requete = $this->database->prepare("SELECT * FROM billetteries WHERE id = :id");

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

  public function update($id, $nom, $place_total, $place_restante, $types, $horaires, $codes_promo) {
    $requete = $this->database->prepare("UPDATE billetteries
                                         SET nom = :nom, place_total = :place_total, place_restante = :place_restante, type = :type, horaire = :horaire, code = :code
                                         WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':place_total', $place_total, PDO::PARAM_INT);
    $requete->bindParam(':place_restante', $place_restante, PDO::PARAM_INT);
    $requete->bindParam(':type', $types);
    $requete->bindParam(':horaire', $horaires);
    $requete->bindParam(':code', $codes_promo);

    $resultat = $requete->execute();

    return $resultat;
  }
}

?>
