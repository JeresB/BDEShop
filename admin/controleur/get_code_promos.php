<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/billetteries.php");

$gestion_bdd = new BDD_BILLETTERIES();

$billetterie = $gestion_bdd->get($_POST['id']);

echo json_encode($billetterie['code']);
?>
