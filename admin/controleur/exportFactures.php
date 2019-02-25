<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/factures.php");

$gestion_bdd_factures = new BDD_FACTURES();

$factures = $gestion_bdd_factures->list();

if(!empty($factures) && $factures != null){
    $delimiter = ";";
    $filename = "factures.csv";

    //create a file pointer
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('id', 'client', 'tel', 'status', 'complement', 'date', 'contenu', 'recu', 'livre');
    fputcsv($f, $fields, $delimiter);

    //output each row of the data, format line as csv and write to file pointer
    foreach ($factures as $key => $facture) {
      $lineData = array($facture['id'], $facture['mail'], $facture['tel'], $facture['status'], $facture['complement'], $facture['date_creation'], $facture['contenu']);
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
