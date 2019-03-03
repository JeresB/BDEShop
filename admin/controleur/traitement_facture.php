<?php

session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/factures.php");

$order_ref = 0;

if (isset($_POST) && !empty($_POST)) {
  $gestion_bdd = new BDD_FACTURES();

  $_SESSION['mail'] = $_POST['mail'];
  $_SESSION['tel'] = $_POST['tel'];

  $order_ref = $gestion_bdd->add($_POST['mail'], $_POST['tel'], $_POST['complement'], $_POST['contenu']);

  echo $order_ref;
}

echo '';
?>
