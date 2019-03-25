<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/factures.php");
session_start();
  $gestion_bdd = new BDD_FACTURES();
print('<pre>'.print_r($gestion_bdd->getEmail(4), true).'</pre>');

?>
