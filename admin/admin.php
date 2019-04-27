<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/controleur/categories.php");
require_once("$root/admin/controleur/promos.php");
require_once("$root/admin/controleur/vendeurs.php");
require_once("$root/admin/controleur/items.php");
require_once("$root/admin/controleur/factures.php");
require_once("$root/admin/controleur/billetteries.php");
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
        Gestion administrateur
      </h2>

      <div class="ui grid">
        <div class="four wide computer sixteen wide mobile column">
          <div class="ui vertical pointing menu">
            <div class="header item">
              Menu Admin
            </div>
            <a id="link_categories" class="active item link_admin_menu" data="categories">
              Catégories
              <div class="ui blue label"><?= $nb_categorie['nb'] ?></div>
            </a>
            <a id="link_promos" class="active item link_admin_menu" data="promos">
              Promos
              <div class="ui blue label"><?= $nb_promos['nb'] ?></div>
            </a>
            <a id="link_vendeurs" class="active item link_admin_menu" data="vendeurs">
              Vendeurs
              <div class="ui blue label"><?= $nb_vendeurs['nb'] ?></div>
            </a>
            <a id="link_items" class="item link_admin_menu" data="items">
              Items
              <div class="ui blue label"><?= $nb_item['nb'] ?></div>
            </a>
            <a id="link_factures" class="item link_admin_menu" data="factures">
              Factures
              <div class="ui blue label"><?= $nb_factures['nb'] ?></div>
            </a>
            <a id="link_events" class="item link_admin_menu" data="events">
              Evénements
              <div class="ui blue label"><?= $nb_billetterie['nb'] ?></div>
            </a>
            <a href="controleur/deconnexion.php" class="item redmenuitem">
              Déconnexion
            </a>
          </div>
        </div>
        <div class="twelve wide computer sixteen wide mobile column">
          <div id="categories" class="ui grid main_content">
            <?php foreach ($categories as $categorie): ?>
              <div class="four wide computer eight wide tablet sixteen wide mobile column">
                <div class="ui card">
                  <div class="content">
                    <div class="header"><span><?= $categorie['nom'] ?></span><span class="ui right floated trashbutton" data="<?= $categorie['id'] ?>"><i class="trash alternate red icon"></i></span></div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="sixteen wide column">
              <div class="">
                <div class="content">
                  <div class="center aligned header">
                    <div class="ui form">
                      <div class="inline fields">
                        <div class="twelve wide field">
                          <input id="newcategorie" type="text" name="newcategorie" placeholder="Nom de la catégorie">
                        </div>
                        <div class="four wide field">
                          <div class="ui submit primary button addcategorie"><i class="plus icon"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="promos" class="ui grid main_content"  style="display: none;">
            <?php foreach ($promos as $promo): ?>
              <div class="four wide computer eight wide tablet sixteen wide mobile column">
                <div class="ui card">
                  <div class="content">
                    <div class="header"><span><?= $promo['nom'] ?></span><span class="ui right floated trashpromo" data="<?= $promo['id'] ?>"><i class="trash alternate red icon"></i></span></div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="sixteen wide column">
              <div class="">
                <div class="content">
                  <div class="center aligned header">
                    <div class="ui form">
                      <div class="inline fields">
                        <div class="twelve wide field">
                          <input id="newpromo" type="text" name="newpromo" placeholder="Nom de la promo">
                        </div>
                        <div class="four wide field">
                          <div class="ui submit primary button addpromo"><i class="plus icon"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="vendeurs" class="ui grid main_content"  style="display: none;">
            <?php foreach ($vendeurs as $vendeur): ?>
              <div class="four wide computer eight wide tablet sixteen wide mobile column">
                <div class="ui card">
                  <div class="content">
                    <div class="header"><span><?= $vendeur['nom'].' : '.$vendeur['token'] ?></span><span class="ui right floated trashvendeurs" data="<?= $vendeur['id'] ?>"><i class="trash alternate red icon"></i></span></div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="sixteen wide column">
              <div class="">
                <div class="content">
                  <div class="center aligned header">
                    <div class="ui form">
                      <div class="inline fields">
                        <div class="six wide field">
                          <input id="new_nom_vendeur" type="text" placeholder="Nom du vendeurs">
                        </div>
                        <div class="six wide field">
                          <input id="new_token_vendeur" type="text" placeholder="Token du vendeurs">
                        </div>
                        <div class="four wide field">
                          <div class="ui submit primary button addvendeurs"><i class="plus icon"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="items" class="ui grid main_content"  style="display: none;">
            <div class="sixteen wide column">
              <div class="ui segment">
                <div class="ui divided items">
                <?php foreach ($items as $item): ?>
                  <div class="item">
                    <a class="ui tiny image" href="/images/<?= $item['photo'] ?>" target="_blank">
                      <img src="/images/<?= $item['photo'] ?>">
                    </a>
                    <div class="content">
                      <a class="header" href="gestion_item.php?id=<?= $item['id'] ?>"><?= $item['nom_item'] ?></a>
                      <div class="meta">
                        <?= $item['categorie'] ?>
                      </div>
                      <div class="description">
                        <p><?= $item['description'] ?></p>
                      </div>
                      <div class="extra">
                        <span class="price">Prix : <?= $item['prix'] ?> €</span>
                        <span class="stock">Stock : <?= $item['stock'] ?></span>
                     </div>
                    </div>
                  </div>
                <?php endforeach; ?>
                </div>
                <div class="sixteen wide column">
                  <div class="">
                    <div class="content">
                      <div class="center aligned header">
                        <button id="new_item" class="ui right labeled icon blue button">
                          <i class="plus icon"></i>
                          Ajouter un item
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="factures" class="ui grid main_content" style="display: none;">
            <div class="ui center aligned segment list_factures">
              <a class="ui fluid basic button" href="/admin/controleur/exportFactures.php">
                Exporter les factures au format CSV
              </a>
              <div class="ui relaxed divided list">
                <table id="factures_table" class="ui selectable celled table datatables" style="width:100%">
                  <thead>
                    <tr>
                      <th>Commande n°</th>
                      <th>Client</th>
                      <th>Status du payement</th>
                      <th>Complement</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($factures as $facture): ?>
                      <?php
                        if ($facture['status'] == 'pending') $status = 'warning';
                        else if ($facture['status'] == 'Payé & mail envoyé') $status = 'positive';
                        else $status = 'negative';
                      ?>
                      <tr class="<?= $status; ?>">
                        <td><a href="facture.php?id=<?= $facture['id']; ?>"><div class="ui blue label"><?= $facture['id']; ?> <i class="edit icon"></i></div></a></td>
                        <td><?= $facture['mail']; ?></td>
                        <td><?= $facture['status']; ?></td>
                        <td><?= $facture['complement']; ?></td>
                        <td><?= $facture['date_creation']; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Commande n°</th>
                      <th>Client</th>
                      <th>Status du payement</th>
                      <th>Complement</th>
                      <th>Date</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div id="events" class="ui grid main_content"  style="display: none;">
            <div class="ui center aligned segment list_billetterie">
              <a class="ui fluid blue button" href="billetterie.php">
                Crée une billetterie
              </a>
              <div class="ui relaxed divided list">
                <table id="billetterie_table" class="ui selectable celled table datatables" style="width:100%">
                  <thead>
                    <tr>
                      <th>Billetterie n°</th>
                      <th>Nom</th>
                      <th>Place</th>
                      <th>Activation</th>
                      <th>Transaction</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($billetteries as $billetterie): ?>
                      <tr>
                        <td><a href="billetterie.php?id=<?= $billetterie['id']; ?>"><div class="ui blue label"><?= $billetterie['id']; ?> <i class="edit icon"></i></div></a></td>
                        <td><?= $billetterie['nom']; ?></td>
                        <td><?= $billetterie['place_restante']; ?> / <?= $billetterie['place_total']; ?></td>
                        <td><?= ($billetterie['active']) ? 'Activé' : 'Désactivé'; ?></td>
                        <td><a class="ui button" href="transactions.php?id=<?= $billetterie['id']; ?>">Collect</a></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Billetterie n°</th>
                      <th>Nom</th>
                      <th>Place</th>
                      <th>Activation</th>
                      <th>Transaction</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../semantic/semantic.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dataTable.min.js"></script>
    <script type="text/javascript" src="../semantic/dataTable.min.js"></script>
    <script type="text/javascript">
      $( document ).ready(function() {
        $(".link_admin_menu").click(function() {
          $(".main_content").hide();
          $(".link_admin_menu").removeClass("active");
          $("#" + $(this).attr("data")).show();
          $("#link_" + $(this).attr("data")).addClass("active");
        });

        $("#new_item").click(function() {
          window.location.replace("/admin/gestion_item.php");
        });

        $(".trashbutton").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/delete_categorie.php',
            data: {id: $(this).attr('data')},
            success: function(data){
              location.reload();
            }
          });
        });

        $(".addcategorie").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/add_categorie.php',
            data: {nom: $("#newcategorie").val()},
            success: function(data){
              location.reload();
            }
          });
        });

        $(".trashpromo").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/delete_promo.php',
            data: {id: $(this).attr('data')},
            success: function(data){
              location.reload();
            }
          });
        });

        $(".addpromo").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/add_promo.php',
            data: {nom: $("#newpromo").val()},
            success: function(data){
              location.reload();
            }
          });
        });

        $(".trashvendeurs").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/delete_vendeur.php',
            data: {id: $(this).attr('data')},
            success: function(data){
              location.reload();
            }
          });
        });

        $(".addvendeurs").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/add_vendeur.php',
            data: {nom: $("#new_nom_vendeur").val(), token: $("#new_token_vendeur").val()},
            success: function(data){
              location.reload();
            }
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
      });
    </script>
  </body>
</html>
