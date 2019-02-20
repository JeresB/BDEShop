function manage_bag(response) {
  window.scrollTo(0, 0);

  var page = $(location).attr("href");

  if (typeof bag !== 'undefined') {
    bag = response
  }

  var div = document.getElementById('bag');
  div.innerHTML = '';

  var contenu = '';

  if (response.length > 0) {

    contenu += '<div class="ui center aligned segment"><h2 class="ui center aligned icon header">';
    contenu += '<i class="shopping basket icon"></i>Panier</h2><div id="list_shopping" class="ui huge middle aligned divided list">';

    prix_total = 0

    for (var i = 0; i < response.length; i++) {
      if(!$.isEmptyObject(response[i])) {
        contenu += '<div class="item"><div class="right floated content">';

        if (page.search( 'boutique' ) > 0) {
          contenu += '<div class="ui red button suppr_item_bag" data="' + i + '">';
          contenu += '<i class="trash alternate icon" style="margin: auto!important;"></i></div>';
        }

        contenu += '</div><div class="content"><div class="header">' + response[i].quantite + ' ' + response[i].nom;

        if ('parametres' in response[i]) {
          contenu += ' ['
          $.each(response[i].parametres, function(j, parametre) {
            contenu += ' ' + parametre.nom + ' : ' + parametre.choix + ' '
          });
          contenu += '] '
        }
        contenu += ' pour un prix de ' + response[i].prix + ' €</div></div></div>';

        prix_total += parseFloat(response[i].prix)
      }
    }

    contenu += '<div class="ui divider"></div><div class="ui statistic"><div class="label">Prix total</div><div class="value">' + prix_total + '</div></div>'


    if (page.search( 'boutique' ) > 0) {
      contenu += '<a class="ui green fluid button" href="buy_item.php"><i class="check icon"></i> Passer commande</a>';
    }
    contenu += '</div></div>';
  }

  div.innerHTML = contenu;
}

function addBag() {
  $("#list_items").on( "click", ".add_bag", function(e) {
    e.preventDefault()

    var parametres = [];
    var id = $(this).attr('identifiant');
    var nom = $('.' + id + 'nom').html();
    var prix = $('.' + id + 'prix').html();
    var quantite = $('.' + id + 'quantite').html();

    if($('.' + id + 'parametre')[0]) {
      var nb_param = $('.parametres_content.' + id).length

      $('.' + id + 'parametre.active').each(function() {
        var parametre = {nom: $(this).attr('param'), choix: $(this).val()};
        parametres.push(parametre)
      })

      if (parametres.length !== nb_param) {
        $.uiAlert({
          textHead: 'Erreur parametres',
          text: 'Veuillez choisir les parametres pour cet item.',
          bgcolor: '#db2828',
          textcolor: '#fff',
          position: 'top-right', // top And bottom ||  left / center / right
          icon: 'redo',
          time: 3
        });
      } else {
        $.ajax({
          type: "GET",
          url: "/admin/controleur/add_bag.php",
          data: {nom: nom, prix: prix, quantite: quantite, parametres: parametres},
          dataType: "json",
          success: manage_bag
        });
      }
    } else {
      $.ajax({
        type: "GET",
        url: "/admin/controleur/add_bag.php",
        data: {nom: nom, prix: prix, quantite: quantite, parametres: parametres},
        dataType: "json",
        success: manage_bag
      });
    }
  });
}

function supprBag() {
  $("#bag").on("click", ".suppr_item_bag", function(e) {
    e.preventDefault();

    console.log("Click suppr bag");

    var key = $(this).attr('data');
    console.log('key = ' + key);

    $.ajax({
      type: "GET",
      url: "/admin/controleur/suppr_bag.php",
      data: {key: key},
      dataType: "json",
      success: manage_bag
    });
  });
}

function getBag() {
  $.ajax({
    type: "GET",
    url: "/admin/controleur/get_bag.php",
    dataType: "json",
    success: manage_bag
  });
}
