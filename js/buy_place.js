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

  var text = '<div class="ui message">Prix : ' + prix + '</div>'

  $("#message_prix").html(text)
}
