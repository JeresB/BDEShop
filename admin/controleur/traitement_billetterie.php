<?php

session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/transactions.php");
require_once("$root/admin/modele/billetteries.php");

$order_ref = 0;

if (isset($_POST) && !empty($_POST)) {
  $gestion_bdd_transaction = new BDD_TRANSACTIONS();
  $gestion_bdd_billetterie = new BDD_BILLETTERIES();

  $_SESSION['mail'] = $_POST['mail'];
  $_SESSION['tel'] = $_POST['tel'];

  error_log(print_r($_POST, true));

  $resultat = $gestion_bdd_billetterie->updateQuantite($_POST['id_billetterie'], $_POST['type_place'], $_POST['horaire']);
  $order_ref = $gestion_bdd_transaction->add($_POST['mail'], $_POST['tel'], $_POST['type_place'], $_POST['horaire'], $_POST['nom'], $_POST['prenom'], $_POST['promo'], $_POST['code_promo'], $_POST['infos_utile'], $_POST['id_billetterie']);

  echo $order_ref;
}

echo '';
?>
