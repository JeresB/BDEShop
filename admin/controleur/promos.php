<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/promos.php");

$gestion_bdd = new BDD_PROMOS();

$promos = $gestion_bdd->list();
$nb_promos = $gestion_bdd->count();

?>
