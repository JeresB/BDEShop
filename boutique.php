<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/categories.php");
?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/head.php"); ?>
  <link rel="stylesheet" type="text/css" href="semantic/Semantic-UI-Alert.css">
  <?php require_once("$root/templates/nav.php"); ?>

  <body>
    <div class="ui container">

      <div id="bag"></div>

      <h2 class="ui center aligned icon header">
        <i class="shopping cart icon"></i>
        Boutique
      </h2>
      <div class="ui grid">
        <div class="four wide computer sixteen wide mobile column">
          <div class="ui vertical pointing menu" style="width: auto;">
            <div class="header item">
              Catégories
            </div>
            <a class="active item categorie_link getItems" link_type = "categorie_link" data = "all">
              All
            </a>
            <?php foreach ($categories as $categorie): ?>
              <a class="item categorie_link getItems" link_type = "categorie_link" data = "<?= $categorie['nom']; ?>">
                <?= $categorie['nom']; ?>
              </a>
            <?php endforeach; ?>
          </div>

          <div class="ui vertical pointing menu" style="width: auto;">
            <div class="header item">
              Tri
            </div>
            <a class="active item tri_link getItems" link_type = "tri_link" data = "nom">
              Nom
            </a>
            <a class="item tri_link getItems" link_type = "tri_link" data = "prix ASC">
              Prix Croissant
            </a>
            <a class="item tri_link getItems" link_type = "tri_link" data = "prix DESC">
              Prix Décroissant
            </a>
            <a class="item tri_link getItems" link_type = "tri_link" data = "stock ASC">
              Stock Croissant
            </a>
            <a class="item tri_link getItems" link_type = "tri_link" data = "stock DESC">
              Stock Décroissant
            </a>
          </div>
        </div>
        <div class="twelve wide computer sixteen wide mobile column">
          <div class="ui segment">
            <div id="list_items" class="ui three stackable cards"></div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="semantic/semantic.min.js"></script>
    <script type="text/javascript" src="js/boutique.js"></script>
    <script type="text/javascript" src="semantic/Semantic-UI-Alert.js"></script>
    <script type="text/javascript" src="js/bag.js"></script>
    <script type="text/javascript">
      $( document ).ready(function() {
        var categorie = 'all';
        var tri = 'nom';
        var prix_total = 0;

        selectParametre();
        addBag();
        supprBag();
        getBag();

        function getItems(categorie, tri) {
          $.ajax({
            type: "GET",
            url: "/admin/controleur/items_shop.php",
            data: {categorie: categorie, tri: tri},
            dataType: "json",
            success: function(response){
              console.log(JSON.stringify(response));

              var div = document.getElementById('list_items');
              div.innerHTML = '';

              var contenu = '';

              for (var i = 0; i < response.length; i++) {
                contenu += '<div class="ui card"><div class="content"><div class="right floated header"><span id="prix' + i + '" prixinit="' + response[i].prix + '" class="' + response[i].id + 'prix">' + response[i].prix + '</span>€';
                contenu += '</div></div><div class="image"><img src="/images/' + response[i].photo + '"></div>';
                contenu += '<div class="content"><div class="header ' + response[i].id + 'nom' + '">' + response[i].nom_item + '</div><div class="meta"><span>' + response[i].categorie + '</span></div>';
                contenu += '<div class="description">' + response[i].description + '</div></div>';
                contenu += '<div class="content">' + ((response[i].stock > 0) ? 'Stock restant : ' + response[i].stock : '<span class="ui red header">Stock épuisée</span>') + '</div>';
                contenu += '<div class="content">Quantité : <button class="ui red circular icon button" data="' + i + '" type="moins"><i class="minus icon"></i></button> <span id="quantite' + i + '" class="' + response[i].id + 'quantite">1</span> <button class="ui green circular icon button" data="' + i + '" type="plus"><i class="plus icon"></i></button></div>';

                if (response[i].parametres !== null) {

                  var parametres = JSON.parse(response[i].parametres)
                  console.log("creation item");
                  console.log(parametres);

                  $.each(parametres, function(j, parametre) {
                    contenu += '<div class="content parametres_content ' + response[i].id + '"><div class="header">' + parametre.nom + '</div>';

                    $.each(parametre.options, function(k, option) {
                      contenu += '<button class="ui button parametre_button ' + response[i].id + parametre.nom + ' ' + response[i].id + 'parametre" data="' + response[i].id + parametre.nom + '" param="' + parametre.nom + '" value="' + option + '">' + option + '</button>';
                    });

                    contenu += '</div>';
                  });
                }

                contenu += '<div class="ui blue bottom attached button add_bag" identifiant="' + response[i].id + '"><i class="add icon"></i> Ajouter au panier</div></div>';

                // contenu += '<div class="item">';
                // contenu += '<a class="ui tiny image" href="/images/';
                // contenu += response[i].photo;
                // contenu += '" target="_blank">';
                // contenu += '<img src="/images/';
                // contenu += response[i].photo;
                // contenu += '">';
                // contenu += '</a>';
                // contenu += '<div class="content">';
                // contenu += '<a class="header" href="buy_item.php?id=';
                // contenu += response[i].id;
                // contenu += '">';
                // contenu += response[i].nom_item;
                // contenu += '</a>';
                // contenu += '<div class="meta">';
                // contenu += response[i].categorie;
                // contenu += '</div>';
                // contenu += '<div class="description"><p>';
                // contenu += response[i].description;
                // contenu += '</p></div>';
                // contenu += '<div class="extra">';
                // contenu += '<span class="price">Prix : ';
                // contenu += response[i].prix;
                // contenu += ' €</span>';
                // contenu += '<span class="stock">Stock : ';
                // contenu += response[i].stock;
                // contenu += '</span>';
                // contenu += '</div>';
                // contenu += '<button class="ui blue right labeled icon button"><i class="right arrow icon"></i> Ajouter au panier </button>';
                // contenu += 'Quantité : <button class="ui red circular icon button" data="' + i + '" type="moins"><i class="minus icon"></i></button> <span id="quantite' + i + '">1</span> <button class="ui green circular icon button" data="' + i + '" type="plus"><i class="plus icon"></i></button>'
                // contenu += '<div class="ui right floated statistic"><div class="value"><span id="prix' + i + '" prixinit="' + response[i].prix + '">' + response[i].prix + '</span>€</div></div>';
                // contenu += '</div>';
                // contenu += '</div>';
              }

              div.innerHTML = contenu;

              $(".circular").click(function(e) {
                e.preventDefault()

                var type = $(this).attr("type");
                var num = $(this).attr("data");

                console.log("circular press | type = " + type + " & num = " + num)


                if (type == 'moins') {
                  $("#quantite" + num).html(parseFloat($("#quantite" + num).html()) - 1);
                } else if (type == 'plus') {
                  $("#quantite" + num).html(parseFloat($("#quantite" + num).html()) + 1);
                }
                var newprix = parseFloat($("#quantite" + num).html()) * parseFloat($("#prix" + num).attr("prixinit"))
                newprix = newprix.toFixed(2);

                $("#prix" + num).html(newprix);
              });
            }
          });
        }

        $(".getItems").click(function() {
          var type = $(this).attr("link_type");

          $("." + type).removeClass("active");
          $(this).addClass("active");

          if (type == "categorie_link") {
            categorie = $(this).attr("data");
          } else if (type == "tri_link") {
            tri = $(this).attr("data");
          }

          getItems(categorie, tri);
        });

        getItems(categorie, tri);
      });
    </script>
  </body>
</html>
