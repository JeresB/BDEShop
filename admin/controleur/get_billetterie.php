<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  require_once("$root/admin/modele/billetteries.php");

  $gestion_bdd = new BDD_BILLETTERIES();

  $billetterie = $gestion_bdd->get($_GET['id']);
  $types = json_decode($billetterie['type']);
  $horaires = json_decode($billetterie['horaire']);
  $codes_promo = json_decode($billetterie['code']);

  if (!$billetterie) {
    echo '<script type="text/javascript">
            window.location.replace("/billetterie.php");
          </script>';
  }
} else {
  echo '<script type="text/javascript">
          window.location.replace("/billetterie.php");
        </script>';
}
?>
