<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/vendeurs.php");

$gestion_bdd = new BDD_VENDEURS();

$vendeurs = $gestion_bdd->list();
$nb_vendeurs = $gestion_bdd->count();

?>
