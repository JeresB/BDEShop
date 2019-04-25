<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/billetteries.php");

$gestion_bdd = new BDD_BILLETTERIES();

$billetteries = $gestion_bdd->list();
$nb_billetterie = $gestion_bdd->count();

?>
