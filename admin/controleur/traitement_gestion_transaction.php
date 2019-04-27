<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/transactions.php");
require_once("$root/admin/modele/billetteries.php");

if (isset($_POST) && !empty($_POST)) {

  error_log("FILE TRAITEMENT GESTION TRANSACTION ".print_r($_POST, true));

  $gestion_bdd_t = new BDD_TRANSACTIONS();
  $gestion_bdd_b = new BDD_BILLETTERIES();

  if ($_POST['old_place'] != $_POST['type_place']) {
    $gestion_bdd_b->equilibreQuantite($_POST['id_billetterie'], $_POST['old_place'], 'moins', $_POST['type_place'], 'plus', 'type');
  }

  if ($_POST['old_horaire'] != $_POST['horaire']) {
    $gestion_bdd_b->equilibreQuantite($_POST['id_billetterie'], $_POST['old_horaire'], 'moins', $_POST['horaire'], 'plus', 'horaire');
  }

  $success = $gestion_bdd_t->update($_POST['id'], $_POST['tel'], $_POST['mail'], $_POST['nom'], $_POST['prenom'], $_POST['promo'], $_POST['type_place'], $_POST['horaire'], $_POST['code_promo'], $_POST['infos_utile'], $_POST['status']);

  echo '<script type="text/javascript">
          window.location.replace("/admin/transactions.php");
        </script>';

} else {
  echo '<script type="text/javascript">
          window.location.replace("/admin/transactions.php");
        </script>';
}
?>
