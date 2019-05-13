<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  require_once("$root/admin/modele/billetteries.php");

  $gestion_bdd = new BDD_BILLETTERIES();

  $billetterie = $gestion_bdd->get($_GET['id']);
  $types = $billetterie['type'];

  echo $types;
}

echo '';
?>
