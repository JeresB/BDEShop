<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/promos.php");

$gestion_bdd = new BDD_PROMOS();

$success = $gestion_bdd->delete($_POST['id']);

?>
