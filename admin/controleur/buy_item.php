<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/categories.php");

$gestion_bdd_categorie = new BDD_CATEGORIES();
$categories = $gestion_bdd_categorie->list();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $find = true;
  $id = $_GET['id'];

  require_once("$root/admin/modele/items.php");

  $gestion_bdd_item = new BDD_ITEMS();

  $item = $gestion_bdd_item->get($id);

  if (!$item) {
    echo '<script type="text/javascript">
            window.location.replace("/boutique.php");
          </script>';
  }
} else {
  $find = false;
  echo '<script type="text/javascript">
          window.location.replace("/boutique.php");
        </script>';
}

?>
