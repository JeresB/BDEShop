<?php
header("Access-Control-Allow-Origin: *");

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/factures.php");

session_start();

unset($_SESSION['shopping_list']);

error_log("SUCCESS PAYEMENT");
error_log(print_r($_POST, true));
error_log(print_r($_SESSION, true));

$order_ref = $_POST['order_ref'];
//$order_ref = 20;


if (isset($order_ref) && $order_ref!= null && $order_ref != '') {
  $gestion_bdd = new BDD_FACTURES();
  $gestion_bdd->updateStatus($order_ref, 'Payé');

  // Import PHPMailer classes into the global namespace
  // These must be at the top of your script, not inside a function
  require '../../vendor/phpmailer/phpmailer/src/Exception.php';
  require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

  require '../../vendor/autoload.php';

  // Create a new PHPMailer instance
  $mail = new PHPMailer\PHPMailer\PHPMailer();

  // Set PHPMailer to use the sendmail transport
  //$mail->isSendmail();

  // Set who the message is to be sent from
  $mail->setFrom('bdecosmunity@contact.fr', 'BDE Cosmunity');

  // Set an alternative reply-to address
  $mail->addReplyTo('bdecosmunity@contact.fr', 'BDE Cosmunity');

  // Set who the message is to be sent to
  $mail->addAddress($_SESSION['mail']);

  // Set the subject line
  $mail->Subject = 'Facture Boutique BDE ISEN';

  // Read an HTML message body from an external file, convert referenced images to embedded,
  // convert HTML into a basic plain-text alternative body
  $mail->msgHTML("<h1>Facture Boutique BDE ISEN</h1><p>Votre commande dans la boutique du BDE ISEN a bien été prise en compte.</p>
  <p>Le BDE ISEN va maintenant s'occuper de votre commande et vous tiendra informé</p>");

  // Replace the plain text body with one created manually
  $mail->AltBody = 'Votre commande dans la boutique du BDE ISEN a bien été prise en compte. Le BDE ISEN va maintenant s\'occuper de votre commande et vous tiendra informé';

  // send the message, check for errors
  if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    //echo "Message sent!";
    $gestion_bdd->updateStatus($order_ref, 'Payé & mail envoyé');
  }
}


?>
