<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = $_GET['id'];

  require_once("$root/admin/modele/factures.php");

  $gestion_bdd_facture = new BDD_FACTURES();

  $facture = $gestion_bdd_facture->get($id);
  $contenu = json_decode($facture['contenu']);

  error_log(print_r($facture, true));

  if (!$facture) {
    echo '<script type="text/javascript">
            window.location.replace("/admin/admin.php");
          </script>';
  }
} else {
  echo '<script type="text/javascript">
          window.location.replace("/admin/admin.php");
        </script>';
}

?>
