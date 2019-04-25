<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/controleur/transactions.php");

error_log(print_r($transactions, true));
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
        Liste Transactions
      </h2>
    </div>

    <div class="ui segment">
      <h4 class="ui header">
        <?php if ($all): ?>
          Liste de toutes les transactions
        <?php else: ?>
          Transactions pour la billetterie n° <strong><?= $transactions[0]['id_Billetterie']; ?></strong>
        <?php endif; ?>
      </h4>

      <div class="ui hidden divider"></div>

      <table class="ui selectable celled table datatables" style="width:100%">
        <thead>
          <tr>
            <th>Transaction n°</th>
            <th>Téléphone</th>
            <th>Mail</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Promo</th>
            <th>Place</th>
            <th>Horaire</th>
            <th>Code promo</th>
            <th>Infos utile</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($transactions as $transaction): ?>
            <tr>
              <td><?= $transaction['id']; ?></td>
              <td><?= $transaction['tel']; ?></td>
              <td><?= $transaction['mail']; ?></td>
              <td><?= $transaction['nom']; ?></td>
              <td><?= $transaction['prenom']; ?></td>
              <td><?= $transaction['promo']; ?></td>
              <td><?= $transaction['place']; ?></td>
              <td><?= $transaction['horaire']; ?></td>
              <td><?= $transaction['code_promo']; ?></td>
              <td><?= $transaction['infos_utile']; ?></td>
              <td><?= $transaction['status']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th>Transaction n°</th>
            <th>Téléphone</th>
            <th>Mail</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Promo</th>
            <th>Place</th>
            <th>Horaire</th>
            <th>Code promo</th>
            <th>Infos utile</th>
            <th>Status</th>
          </tr>
        </tfoot>
      </table>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../semantic/semantic.min.js"></script>
  </body>
</html>
