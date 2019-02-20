<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/items.php");

$gestion_bdd = new BDD_ITEMS();

$items = $gestion_bdd->list();
$nb_item = $gestion_bdd->count();

?>
