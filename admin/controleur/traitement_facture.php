<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/factures.php");

if (isset($_POST) && !empty($_POST)) {
  $gestion_bdd = new BDD_FACTURES();

  $success = $gestion_bdd->add($_POST['id'], $_POST['mail'], $_POST['tel'], $_POST['complement']);
}

?>
