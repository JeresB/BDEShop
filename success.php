<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

//require_once("$root/admin/controleur/success.php");
?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/head.php"); ?>
  <?php require_once("$root/templates/nav.php"); ?>

  <body>
    <div class="ui container">
      <div class="ui green icon message">
        <i class="check icon"></i>
        <div class="content">
          <div class="header">
            Payement réussi !
          </div>
          <p>Vous allez recevoir un email de confiramtion de votre commande.</p>
        </div>
      </div>
      <img class="ui image" src="https://via.placeholder.com/600.png?text=BDE+Cosmunity+Image">
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="semantic/semantic.min.js"></script>
  </body>
</html>


<?php

//supprimer bag session
// Message success avec information demander a arthur

?>
