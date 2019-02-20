<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/categories.php");

$gestion_bdd = new BDD_CATEGORIES();

$success = $gestion_bdd->add($_POST['nom']);

?>
