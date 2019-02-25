<?php

session_start()

unset($_SESSION['shopping_list']);

error_log("SUCCESS PAYEMENT");
error_log(print_r($_POST, true));

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;

require '../../vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer;

// Set PHPMailer to use the sendmail transport
//$mail->isSendmail();

// Set who the message is to be sent from
$mail->setFrom('bdecosmunity@contact.fr', 'BDE Cosmunity');

// Set an alternative reply-to address
$mail->addReplyTo('bdecosmunity@contact.fr', 'BDE Cosmunity');

// Set who the message is to be sent to
$mail->addAddress('boiselet.jeremy@gmail.com', 'Jeres');

// Set the subject line
$mail->Subject = 'PHPMailer sendmail test';

// Read an HTML message body from an external file, convert referenced images to embedded,
// convert HTML into a basic plain-text alternative body
$mail->msgHTML("<h1>Coucou</h1>");

// Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

// send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

?>
