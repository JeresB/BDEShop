function selectParametre() {
  $("#list_items").on( "click", ".parametre_button", function(e) {
    e.preventDefault()

    $('.' + $(this).attr('data')).removeClass('active')
    $(this).addClass('active')
  });
}

function manage_bag(response) {
  console.log("Reponse d'ajout d'un item depuis manage_bag");
  console.log(JSON.stringify(response));

  if (response.length > 0) {
    var div = document.getElementById('bag');
    div.innerHTML = '';

    var contenu = '<div class="ui center aligned segment"><h2 class="ui center aligned icon header">';
    contenu += '<i class="shopping basket icon"></i>Panier</h2><div id="list_shopping" class="ui huge middle aligned divided list">';

    var prix_total = 0

    for (var i = 0; i < response.length; i++) {
      if(!$.isEmptyObject(response[i])) {
        contenu += '<div class="item"><div class="right floated content"><div class="ui red button suppr_item_bag" data="' + i + '">';
        contenu += '<i class="trash alternate icon" style="margin: auto!important;"></i></div></div>';
        contenu += '<div class="content"><div class="header">' + response[i].quantite + ' ' + response[i].nom;
        contenu += ' pour un prix de ' + response[i].prix + ' €</div></div></div>';

        prix_total += response[i].prix
      }
    }

    contenu += '</div></div>';

    div.innerHTML = contenu;
  }
}

function addBag() {
  $("#list_items").on( "click", ".add_bag", function(e) {
    e.preventDefault()

    var parametres = [];
    var nom = $('.' + $(this).attr('identifiant') + 'nom').html();
    var prix = $('.' + $(this).attr('identifiant') + 'prix').html();
    var quantite = $('.' + $(this).attr('identifiant') + 'quantite').html();

    console.log("Click add bag");
    console.log($(this).attr('identifiant'));
    console.log($('.' + $(this).attr('identifiant') + 'nom').html());
    console.log($('.' + $(this).attr('identifiant') + 'prix').html());
    console.log($('.' + $(this).attr('identifiant') + 'quantite').html());

    if($(".parametres_content")[0]) {
      var nb_param = $(".parametres_content").length
      $('.' + $(this).attr('identifiant') + 'parametre.active').each(function() {
        console.log($(this).val());
        var parametre = {nom: $(this).attr('param'), choix: $(this).val()};
        parametres.push(parametre)
      })

      console.log(parametres);
      if (parametres.length !== nb_param) {
        console.log("ATTENTION PARAMETRES");
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
