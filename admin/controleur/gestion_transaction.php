<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");

if (isset($_GET['id_transaction']) && is_numeric($_GET['id_transaction'])) {
  $id = $_GET['id_transaction'];

  require_once("$root/admin/modele/transactions.php");

  $gestion_bdd = new BDD_TRANSACTIONS();

  $transaction = $gestion_bdd->get($id);

  if (!$transaction) {
    echo '<script type="text/javascript">
            window.location.replace("/admin/transactions.php");
          </script>';
  }
} else {
  echo '<script type="text/javascript">
          window.location.replace("/admin/transactions.php");
        </script>';
}
?>
