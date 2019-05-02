<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/controleur/transactions.php");

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
          <a class="ui basic button" href="/admin/controleur/exportTransactions.php">
            Exporter les transactions au format CSV
          </a>
        <?php else: ?>
          Transactions pour la billetterie n° <strong><?= $transactions[0]['id_Billetterie']; ?></strong>
          <a class="ui basic blue button" href="transactions.php">Toutes les transactions</a>
          <a class="ui basic button" href="/admin/controleur/exportTransactions.php?id=<?= $transactions[0]['id_Billetterie']; ?>">
            Exporter les transactions au format CSV
          </a>
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
            <th>Date</th>
            <th>Supprimer</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($transactions as $transaction): ?>
            <tr class='clickable-row' data-href="transaction.php?id=<?= $transactions[0]['id_Billetterie']; ?>&id_transaction=<?= $transaction['id']; ?>" style="cursor: pointer;">
              <td><a href="transaction.php?id=<?= $transactions[0]['id_Billetterie']; ?>&id_transaction=<?= $transaction['id']; ?>"><div class="ui blue label"><?= $transaction['id']; ?> <i class="edit icon"></i></div></a></td>
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
              <td><?= $transaction['date_creation']; ?></td>
              <td><button class="ui red button supprtransaction" type="button" data="<?= $transaction['id'] ?>"><i class="trash alternate icon"></i></button></td>
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
            <th>Date</th>
            <th>Supprimer</th>
          </tr>
        </tfoot>
      </table>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../semantic/semantic.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dataTable.min.js"></script>
    <script type="text/javascript" src="../semantic/dataTable.min.js"></script>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        $(".supprtransaction").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/delete_transaction.php',
            data: {id: $("#id_transaction").val()},
            success: function(data){
              window.location.reload();
            }
          });
        });
      });
      $('.datatables').DataTable( {
        language: {
          processing:     "Traitement en cours...",
          search:         "Rechercher&nbsp;:",
          lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
          info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
          infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
          infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          infoPostFix:    "",
          loadingRecords: "Chargement en cours...",
          zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
          emptyTable:     "Aucune donnée disponible dans le tableau",
          paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
          },
          aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
        }
      });
    </script>
  </body>
</html>
