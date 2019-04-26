<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/transactions.php");

$gestion_bdd = new BDD_TRANSACTIONS();
$transactions = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $transactions = $gestion_bdd->list($_GET['id']);
} else {
  $transactions = $gestion_bdd->listAll();
}

if(!empty($transactions) && $transactions != null){
  $delimiter = ";";
  $filename = "transactions.csv";

  //create a file pointer
  $f = fopen('php://memory', 'w');

  //set column headers
  $fields = array('id', 'id_billetterie', 'tel', 'mail', 'nom', 'prenom', 'promo', 'place', 'horaire', 'code_promo', 'infos_utile', 'status');
  fputcsv($f, $fields, $delimiter);

  //output each row of the data, format line as csv and write to file pointer
  foreach ($transactions as $key => $transaction) {
    $lineData = array($transaction['id'], $transaction['id_Billetterie'], $transaction['tel'], $transaction['mail'], $transaction['nom'], $transaction['prenom'], $transaction['promo'], $transaction['place'], $transaction['horaire'], $transaction['code_promo'], $transaction['infos_utile'], $transaction['status']);
    fputcsv($f, $lineData, $delimiter);
  }

  //move back to beginning of file
  fseek($f, 0);

  //set headers to download file rather than displayed
  header('Content-type: text/csv; charset=UTF-8');
  header('Content-Disposition: attachment; filename="' . $filename . '";');

  //output all remaining data on a file pointer
  fpassthru($f);
}
exit;

?>
