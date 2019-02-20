<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/factures.php");

$gestion_bdd = new BDD_FACTURES();

$factures = $gestion_bdd->list();
$nb_factures = $gestion_bdd->count();

?>
