<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/categories.php");

$gestion_bdd = new BDD_CATEGORIES();

$categories = $gestion_bdd->list();
$nb_categorie = $gestion_bdd->count();

?>
