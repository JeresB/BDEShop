<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/controleur/gestion_facture.php");

?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/headAdmin.php"); ?>
  <?php require_once("$root/templates/nav.php"); ?>

  <body>
    <div class="ui container">
      <div class="ui hidden divider"></div>
      <h2 class="ui center aligned icon header">
        <i class="circular settings icon"></i>
        Gestion Facture
      </h2>

      <div class="ui segment">
        <h4 class="ui header">Facture n° <strong><?= $facture['id']; ?></strong></h4>
        <p>
          Client : <strong><?= $facture['mail']; ?></strong><br />
          Téléphone : <strong><?= $facture['tel']; ?></strong><br />
          Status : <strong><?= $facture['status']; ?></strong><br />
          Message complémentaire : <strong><?= $facture['complement']; ?></strong><br />
          Date de création : <strong><?= $facture['date_creation']; ?></strong><br />
          Liste des objets :<br />
          <ul class="ui list">
            <?php foreach ($contenu as $key => $value): ?>
              <strong>Nom : <?= $value->{'nom'} ?> | Quantité : <?= $value->{'quantite'} ?> | Prix : <?= $value->{'prix'} ?></strong>
            <?php endforeach; ?>
          </ul>
        </p>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../semantic/semantic.min.js"></script>
  </body>
</html>
