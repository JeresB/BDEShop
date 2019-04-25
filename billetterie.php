<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/billetteries.php");
?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/head.php"); ?>
  <?php require_once("$root/templates/nav.php"); ?>

  <body>
    <div class="ui container">
      <h2 class="ui center aligned icon header">
        <i class="ticket alternate icon"></i>
        Billetterie
      </h2>

      <div class="ui raised segment">
        <table id="billetterie_table" class="ui selectable celled table datatables" style="width:100%">
          <thead>
            <tr>
              <th>Billetterie n°</th>
              <th>Nom</th>
              <th>Place</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($billetteries as $billetterie): ?>
              <tr>
                <td><?= $billetterie['id']; ?></td>
                <td><?= $billetterie['nom']; ?></td>
                <td><?= $billetterie['place_restante']; ?> / <?= $billetterie['place_total']; ?></td>
                <td><a class="ui button" href="buy_place.php?id=<?= $billetterie['id']; ?>">Prendre sa place</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Billetterie n°</th>
              <th>Nom</th>
              <th>Place</th>
              <th>Action</th>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="semantic/semantic.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTable.min.js"></script>
    <script type="text/javascript" src="semantic/dataTable.min.js"></script>
    <script type="text/javascript">
      $( document ).ready(function() {
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
      });
    </script>
  </body>
</html>
