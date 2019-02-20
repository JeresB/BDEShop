<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/items.php");

$gestion_bdd = new BDD_ITEMS();

$items = $gestion_bdd->listWithFiltre($_GET['categorie'], $_GET['tri']);

echo json_encode($items);

?>
