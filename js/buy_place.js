function setFormPeople() {
  $("#nb_place").change(function() {
    var nb = $(this).val()
    var div = document.getElementById('personnes');
    div.innerHTML = '';

    var contenu = '';

    for (var i = 0; i < nb; i++) {
      contenu += '<div class="field">'
      contenu += '  <label>Promo</label>'
      contenu += '  <select class="ui dropdown">'
      contenu += '    <option value="">Promo</option>'
      // contenu += '    <?php foreach ($promos as $promo): ?>'
      // contenu += '      <option value="<?= $promo['id'] ?>"><?= $promo['nom'] ?></option>'
      // contenu += '    <?php endforeach; ?>'
      contenu += '  </select>'
      contenu += '</div>'

      contenu += '<div class="field">'
      contenu += '  <label>Nom</label>'
      contenu += '  <input type="text" name="nom[]">'
      contenu += '</div>'

      contenu += '<div class="field">'
      contenu += '  <label>Prénom</label>'
      contenu += '  <input type="text" name="prenom[]">'
      contenu += '</div>'

      contenu += '<div class="ui divider"></div>'
    }

    div.innerHTML = contenu;
  });
}

function get_places() {
  var place_restante = 9999999999
  $.ajax({
    type: "get",
    url: "/admin/controleur/get_places.php",
    data: {id: $("#id_billetterie").val()},
    dataType: "json",
    success: function(data) {
      $('#place_disponible').html('Places disponible : ' + data.place_restante)
      place_restante = data.place_restante

      $.ajax({
        type: "get",
        url: "/admin/controleur/get_types_place.php",
        data: {id: $("#id_billetterie").val()},
        dataType: "json",
        success: function(data) {
          //console.log(JSON.stringify(data));
          //console.log(data[0])
          $("#show_type_place").html('')

          $.each(data, function( index, value ) {
            var quantite = (value.quantite - value.place_prise)
            var id = value.nom.trim().replace(/ /g,"");

            if (quantite <= 0) {
              $("#" + id).prop('disabled' , true)

              $("#show_type_place").append('<p class="red text">' + value.nom + ' / Prix : ' + value.prix + ' / Quantité restante : ' + quantite + '<p>')
            } else {
              if (quantite > place_restante) {
                quantite = place_restante
              }
              //console.log("Quantite = " + quantite + " & place_restante = " + place_restante);
              $("#show_type_place").append('<p class="green text">' + value.nom + ' / Prix : ' + value.prix + ' / Quantité restante : ' + quantite + '<p>')
            }
          });
        }
      })

      setTimeout(function(){ get_places() }, 1000)
    }
  })
}

function get_horaire() {
  $.ajax({
    type: "get",
    url: "/admin/controleur/get_horaires.php",
    data: {id: $("#id_billetterie").val()},
    dataType: "json",
    success: function(data) {
      //console.log(JSON.stringify(data));
      //console.log(data[0])
      $("#show_horaire").html('')

      $.each(data, function( index, value ) {
        var quantite = (value.quantite - value.place_prise)
        var id = value.nom.trim().replace(/ /g,"");

        if (quantite <= 0) {

          $("#" + id).prop('disabled' , true)

          $("#show_horaire").append('<p class="red text">' + value.nom + ' / Quantité restante : ' + quantite + '<p>')
        } else {
          $("#show_horaire").append('<p class="green text">' + value.nom + ' / Quantité restante : ' + quantite + '<p>')
        }
      });

      setTimeout(function(){ get_horaire() }, 1000)
    }
  })
}

function gestion_promo() {
  $("#code_promo").change(function() {
    $.ajax({
      type: "POST",
      url: '/admin/controleur/get_code_promos.php',
      data: {id: $("#id_billetterie").val()},
      dataType: "json",
      success: function(codes_promo){
        console.log(codes_promo);
        codes_promo = JSON.parse(codes_promo)

        $.each(codes_promo, function(i, code_promo) {
          console.log(JSON.stringify(code_promo));

          if ($('#code_promo').val() == code_promo.nom && code_promo.quantite > 0) {
            var div = document.getElementById('message_code_promo');
            div.innerHTML = 'test';

            var text = '<div class="ui message">Le code promo : ' + code_promo.nom + ' de type : ' + code_promo.type + ' avec un effet de : ' + code_promo.effet + ' a été appliqué.</div><div class="ui hidden divider"></div>';

            div.innerHTML = text;

            console.log(code_promo.nom);
            $('#code_promo').attr('type_promo', code_promo.type)
            $('#code_promo').attr('effet', code_promo.effet)
            gestion_prix()
          }
        });
      }
    });
  });
}

function gestion_prix() {
  var id = $('#type_place').val().trim().replace(/ /g,"");
  var prix = $('#' + id).attr('prix');

  var type_code_promo = $('#code_promo').attr('type_promo');
  var effet_code_promo = $('#code_promo').attr('effet');

  if (type_code_promo === 'prix') {
    prix = effet_code_promo
  } else if (type_code_promo === 'reduction') {
    prix -= effet_code_promo
  } else if (type_code_promo === 'pourcentage') {
    prix = prix * (effet_code_promo/100)
  }

  $('#prix').val(prix);

  var text = '<div class="ui massive message">Prix : ' + prix + '</div>'

  $("#message_prix").html(text)
}

$("#createTransacAdmin").click(function(event) {
  event.preventDefault();
  $(this).attr("disabled", true);

  var type_place = $('#type_place').val()
  var horaire = $('#horaire').val()
  var nom = $("#nom").val()
  var prenom = $("#prenom").val()
  var promo = $("#promo").val()
  var code_promo = $("#code_promo").val()
  var infos_utile = $.trim($("#infos_utile").val())
  var id_billetterie = $("#id_billetterie").val()

  console.log("Horaire = " + horaire);
  console.log("Place = " + type_place);

  if (horaire == '' || type_place == '') {
    $.uiAlert({
      textHead: 'Erreur',
      text: 'Pour enregistrer une place, veuillez choisir un type de place et un horaire de navette',
      bgcolor: '#DF0101',
      textcolor: '#fff',
      position: 'top-right',
      icon: 'close box',
      time: 3,
    })

    $(this).attr("disabled", false);
    return;
  }

  request = $.ajax({
    type: 'POST',
    url: 'admin/controleur/traitement_billetterie.php',
    data: {
      mail: 'BDE',
      tel: 'BDE',
      type_place: type_place,
      horaire: horaire,
      nom: nom,
      prenom: prenom,
      promo: promo,
      code_promo: code_promo,
      infos_utile: infos_utile,
      id_billetterie: id_billetterie
    }
  });

  request.done(function(order_ref, textStatus, jqXHR) {
    if (order_ref == 'redirection') {
      alert("La place demandée n'est plus disponible, veuillez recharger la page !")
      return
    }

    $.ajax({
      url: "/admin/controleur/success_billetterie.php",
      type: 'POST',
      data: {
        order_ref: order_ref
      }
    }).done(function() {
      $.uiAlert({
        textHead: 'Enregistrement',
        text: 'La place a bien été enregistrée. Type : ' + type_place + ' & Horaire : ' + horaire,
        bgcolor: '#01DF01',
        textcolor: '#fff',
        position: 'top-right',
        icon: 'checkmark box',
        time: 3,
      })
    });
  });

  $(this).attr("disabled", false);
})
