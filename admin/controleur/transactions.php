<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/transactions.php");

$gestion_bdd = new BDD_TRANSACTIONS();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $all = false;
  $id = $_GET['id'];

  $transactions = $gestion_bdd->list($id);

} else {
  $all = true;

  $transactions = $gestion_bdd->listAll();
}

?>
