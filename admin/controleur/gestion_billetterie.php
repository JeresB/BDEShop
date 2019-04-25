<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $update = true;
  $id = $_GET['id'];

  require_once("$root/admin/modele/billetteries.php");

  $gestion_bdd = new BDD_BILLETTERIES();

  $billetterie = $gestion_bdd->get($id);

  $types = json_decode($billetterie['type']);
  $type_num = 0;

  $horaires = json_decode($billetterie['horaire']);
  $horaire_num = 0;

  $codes_promo = json_decode($billetterie['code']);
  $code_promo_num = 0;

  error_log(print_r($billetterie, true));

  if (!$billetterie) {
    echo '<script type="text/javascript">
            window.location.replace("/admin/admin.php");
          </script>';
  }
} else {
  $update = false;
  $types = [];
  $type_num = 0;

  $horaires = [];
  $horaire_num = 0;

  $codes_promo = [];
  $code_promo_num = 0;
}

?>
