<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/transactions.php");

$gestion_bdd = new BDD_TRANSACTIONS();

$resultat = $gestion_bdd->count($_POST['id']);

//error_log(print_r($resultat, true));
//error_log($resultat['nb']);
echo $resultat['nb'];
?>
