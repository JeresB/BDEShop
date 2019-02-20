<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/categories.php");

$gestion_bdd_categorie = new BDD_CATEGORIES();
$categories = $gestion_bdd_categorie->list();
$parametres = [];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $update = true;
  $id = $_GET['id'];

  require_once("$root/admin/modele/items.php");

  $gestion_bdd_item = new BDD_ITEMS();

  $item = $gestion_bdd_item->get($id);



  $parametres = json_decode($item['parametres']);

  if ($parametres == '') {
    $parametres = [];
  }

  error_log(print_r($item, true));

  if (!$item) {
    echo '<script type="text/javascript">
            window.location.replace("/admin/admin.php");
          </script>';
  }
} else {
  $update = false;
}

?>
