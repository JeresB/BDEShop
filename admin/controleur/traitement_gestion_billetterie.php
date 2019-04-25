<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/billetteries.php");

if (isset($_POST) && !empty($_POST)) {
  $update = $_POST['update'];

  $types = json_encode($_POST['types']);
  $horaires = json_encode($_POST['horaires']);
  $codes_promo = json_encode($_POST['codes_promo']);

  //error_log(print_r($_POST, true));

  $gestion_bdd = new BDD_BILLETTERIES();

  if ($update == 1) {
    $success = $gestion_bdd->update($_POST['id'], $_POST['nom'], $_POST['place_total'], $_POST['place_restante'], $types, $horaires, $codes_promo);
  } else {
    $success = $gestion_bdd->add($_POST['nom'], $_POST['place_total'], $_POST['place_restante'], $types, $horaires, $codes_promo);
  }

  echo '<script type="text/javascript">
          window.location.replace("/admin/admin.php");
        </script>';

} else {
  echo '<script type="text/javascript">
          window.location.replace("/admin/admin.php");
        </script>';
}
?>
