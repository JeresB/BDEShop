<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/billetteries.php");

$gestion_bdd = new BDD_BILLETTERIES();

$success = $gestion_bdd->delete($_POST['id']);

?>
