<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/bdd/bdd_var.php");

class BDD_BILLETTERIES {

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
    $requete = $this->database->prepare("SELECT count(id) as nb FROM billetteries");

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function list() {
    $requete = $this->database->prepare("SELECT id, nom, description, place_total, place_restante, photo, active FROM billetteries ORDER BY id");

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

  public function updateQuantite($id, $type, $horaire) {
    $requete = $this->database->prepare("SELECT * FROM billetteries WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetch();

    $types = json_decode($resultat['type']);
    $horaires = json_decode($resultat['horaire']);

    foreach ($types as $key => $t) {
      if ($t->{'nom'} == $type) {
        $types->{$key}->{'place_prise'} += 1;
      }
    }

    foreach ($horaires as $key => $h) {
      if ($h->{'nom'} == $horaire) {
        $horaires->{$key}->{'place_prise'} += 1;
      }
    }

    $types = json_encode($types);
    $horaires = json_encode($horaires);

    $requete = $this->database->prepare("UPDATE billetteries
                                         SET place_restante	= place_restante - 1, type = :type, horaire = :horaire
                                         WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':type', $types);
    $requete->bindParam(':horaire', $horaires);

    $resultat = $requete->execute();
  }

  public function updateQuantiteCodePromo($id, $code_promo) {
    $requete = $this->database->prepare("SELECT * FROM billetteries WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetch();

    $codes_promo = json_decode($resultat['code']);

    foreach ($codes_promo as $key => $c) {
      if ($c->{'nom'} == $code_promo) {
        $codes_promo->{$key}->{'quantite'} -= 1;
      }
    }

    $codes_promo = json_encode($codes_promo);

    $requete = $this->database->prepare("UPDATE billetteries
                                         SET code = :code
                                         WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':code', $codes_promo);

    $resultat = $requete->execute();
  }

  public function equilibreQuantite($id, $nom1, $effet1, $nom2, $effet2, $var) {
    $requete = $this->database->prepare("SELECT * FROM billetteries WHERE id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetch();

    $result = json_decode($resultat[$var]);
    //error_log("RESULTAT = ".print_r($result->{'11'}->{'place_prise'}, true));

    foreach ($result as $key => $v) {
      if ($v->{'nom'} == $nom1) {
        if ($effet1 == 'moins') {
          $result->{$key}->{'place_prise'} -= 1;
        } elseif ($effet1 == 'plus') {
          $result->{$key}->{'place_prise'} += 1;
        }
      }

      if ($v->{'nom'} == $nom2) {
        if ($effet2 == 'moins') {
          $result->{$key}->{'place_prise'} -= 1;
        } elseif ($effet2 == 'plus') {
          $result->{$key}->{'place_prise'} += 1;
        }
      }
    }

    $result = json_encode($result);

    $query = "UPDATE billetteries SET ".$var." = :var WHERE id = :id";

    $requete = $this->database->prepare($query);

    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':var', $result);

    $resultat = $requete->execute();
  }

  public function delete($id) {
    $requete = $this->database->prepare("DELETE FROM billetteries WHERE id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function add($nom, $description, $token, $place_total, $place_restante, $types, $horaires, $codes_promo, $photo, $activation) {
    $requete = $this->database->prepare("INSERT INTO billetteries (nom, description, token, place_total, place_restante, type, horaire, code, photo, active)
                                         VALUES (:nom, :description, :token, :place_total, :place_restante, :type, :horaire, :code, :photo, :active)");

    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    $requete->bindParam(':token', $token, PDO::PARAM_STR);
    $requete->bindParam(':place_total', $place_total, PDO::PARAM_INT);
    $requete->bindParam(':place_restante', $place_restante, PDO::PARAM_INT);
    $requete->bindParam(':type', $types);
    $requete->bindParam(':horaire', $horaires);
    $requete->bindParam(':code', $codes_promo);
    $requete->bindParam(':photo', $photo, PDO::PARAM_STR);
    $requete->bindParam(':active', $activation);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function update($id, $nom, $description, $token, $place_total, $place_restante, $types, $horaires, $codes_promo, $photo, $activation) {
    $requete = $this->database->prepare("UPDATE billetteries
                                         SET nom = :nom, description = :description, token = :token, place_total = :place_total, place_restante = :place_restante, type = :type, horaire = :horaire, code = :code, active = :active, photo = :photo
                                         WHERE id = :id");

    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    $requete->bindParam(':token', $token, PDO::PARAM_STR);
    $requete->bindParam(':place_total', $place_total, PDO::PARAM_INT);
    $requete->bindParam(':place_restante', $place_restante, PDO::PARAM_INT);
    $requete->bindParam(':type', $types);
    $requete->bindParam(':horaire', $horaires);
    $requete->bindParam(':code', $codes_promo);
    $requete->bindParam(':photo', $photo, PDO::PARAM_STR);
    $requete->bindParam(':active', $activation);

    $resultat = $requete->execute();

    return $resultat;
  }
}

?>
