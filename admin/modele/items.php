<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/bdd/bdd_var.php");

class BDD_ITEMS {

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
    $requete = $this->database->prepare("SELECT items.id, items.nom as nom_item, stock, prix, description, photo, categories.nom as categorie FROM items, categories WHERE items.id_categories = categories.id");

    $requete->execute();

    $resultat = $requete->fetchAll();

    return $resultat;
  }

  public function listWithFiltre($categorie, $tri) {
    $where_categorie = false;
    $where_tri = " ORDER BY items.".$tri;

    if ($categorie != "all") {
      $where_categorie = " AND categories.nom = :categorie";
    }

    $query = "SELECT items.id, items.nom as nom_item, stock, prix, description, photo, parametres, categories.nom as categorie FROM items, categories WHERE items.id_categories = categories.id";

    error_log($query);
    if ($where_categorie) {
      $query .= $where_categorie;
    }

    $query .= $where_tri;

    $requete = $this->database->prepare($query);

    if ($where_categorie) {
      $requete->bindParam(':categorie', $categorie, PDO::PARAM_STR);
    }

    $requete->execute();

    $resultat = $requete->fetchAll();

    return $resultat;
  }

  public function get($id) {
    $requete = $this->database->prepare("SELECT items.id, items.nom as nom_item, stock, prix, description, photo, parametres, categories.nom as categorie FROM items, categories WHERE items.id_categories = categories.id AND items.id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function count() {
    $requete = $this->database->prepare("SELECT count(id) as nb FROM items");

    $requete->execute();

    $resultat = $requete->fetch();

    return $resultat;
  }

  public function delete($id) {
    $requete = $this->database->prepare("DELETE FROM items WHERE id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function addWithPicture($nom, $stock, $prix, $description, $photo, $parametre, $categorie) {
    $requete = $this->database->prepare("INSERT INTO items (nom, stock, prix, description, photo, parametres, id_categories)
                                         VALUES (:nom, :stock, :prix, :description, :photo, :parametre, :categorie)");
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':stock', $stock, PDO::PARAM_INT);
    $requete->bindParam(':prix', $prix, PDO::PARAM_INT);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    $requete->bindParam(':photo', $photo, PDO::PARAM_STR);
    $requete->bindParam(':parametre', $parametre);
    $requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function add($nom, $stock, $prix, $description, $parametre, $categorie) {
    $requete = $this->database->prepare("INSERT INTO items (nom, stock, prix, description, parametres, id_categories)
                                         VALUES (:nom, :stock, :prix, :description, :parametre, :categorie)");
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':stock', $stock, PDO::PARAM_INT);
    $requete->bindParam(':prix', $prix, PDO::PARAM_INT);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    $requete->bindParam(':parametre', $parametre);
    $requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function updateWithPicture($id, $nom, $stock, $prix, $description, $photo, $parametre, $categorie) {
    $requete = $this->database->prepare("UPDATE items
                                         SET nom = :nom, stock = :stock, prix = :prix, description = :description, photo = :photo, parametres = :parametre, id_categories = :categorie
                                         WHERE id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':stock', $stock, PDO::PARAM_INT);
    $requete->bindParam(':prix', $prix, PDO::PARAM_INT);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    $requete->bindParam(':photo', $photo, PDO::PARAM_STR);
    $requete->bindParam(':parametre', $parametre);
    $requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }

  public function update($id, $nom, $stock, $prix, $description, $parametre, $categorie) {
    $requete = $this->database->prepare("UPDATE items
                                         SET nom = :nom, stock = :stock, prix = :prix, description = :description, parametres = :parametre, id_categories = :categorie
                                         WHERE id = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->bindParam(':stock', $stock, PDO::PARAM_INT);
    $requete->bindParam(':prix', $prix, PDO::PARAM_INT);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    $requete->bindParam(':parametre', $parametre);
    $requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);

    $resultat = $requete->execute();

    return $resultat;
  }
}

?>
