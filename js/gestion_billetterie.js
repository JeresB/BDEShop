function deleteType() {
  $("#types").on( "click", ".supprtype", function(e) {
    e.preventDefault()

    var id = $(this).attr("data")

    $("#type" + id).remove()
  });
}

function addType() {
  $("#types").on( "click", ".addtype", function(e) {
    e.preventDefault()

    var num = $(this).attr("type_nb") + 1

    var text = '<div id="type' + num + '" class="ui grid">'
    text += '<div class="four wide column"><input type="text" placeholder="nom" name="types[' + num + '][nom]" value=""></div>'
    text += '<div class="three wide column"><input type="text" placeholder="prix" name="types[' + num + '][prix]" value=""></div>'
    text += '<div class="three wide column"><input type="text" placeholder="quantite" name="types[' + num + '][quantite]" value=""></div>'
    text += '<div class="three wide column"><input type="text" placeholder="place_prise" name="types[' + num + '][place_prise]" value="0"></div>'
    text += '<div class="three wide column"><button class="ui fluid basic red button supprtype" data="' + num + '"><i class="trash icon"></i></button></div></div>'

    $("#div_types").append(text)

    $(this).attr("type_nb", num)
  });
}

function deleteHoraire() {
  $("#horaires").on( "click", ".supprhoraire", function(e) {
    e.preventDefault()

    var id = $(this).attr("data")

    $("#horaire" + id).remove()
  });
}

function addHoraire() {
  $("#horaires").on( "click", ".addhoraire", function(e) {
    e.preventDefault()

    var num = $(this).attr("horaire_nb") + 1

    var text = '<div id="type' + num + '" class="ui grid">'
    text += '<div class="four wide column"><input type="text" placeholder="nom" name="horaires[' + num + '][nom]" value=""></div>'
    text += '<div class="four wide column"><input type="text" placeholder="quantite" name="horaires[' + num + '][quantite]" value=""></div>'
    text += '<div class="four wide column"><input type="text" placeholder="place prise" name="horaires[' + num + '][place_prise]" value="0"></div>'
    text += '<div class="four wide column"><button class="ui fluid basic red button supprtype" data="' + num + '"><i class="trash icon"></i></button></div></div>'

    $("#div_horaires").append(text)

    $(this).attr("horaire_nb", num)
  });
}

function deleteCode_Promo() {
  $("#codes_promo").on( "click", ".supprcode_promo", function(e) {
    e.preventDefault()

    var id = $(this).attr("data")

    $("#code_promo" + id).remove()
  });
}

function addCode_Promo() {
  $("#codes_promo").on( "click", ".addcode_promo", function(e) {
    e.preventDefault()

    var num = $(this).attr("code_promo_nb") + 1

    var text = '<div id="type' + num + '" class="ui grid">'
    text += '<div class="four wide column"><input type="text" placeholder="nom" name="codes_promo[' + num + '][nom]" value=""></div>'

    text += '<div class="three wide column"><div class="field"><select id="type_code_promo" class="ui dropdown" name="codes_promo[' + num + '][type]" value="">';
    text += '<option value="">Type de code promo</option><option value="prix">Prix</option>';
    text += '<option value="pourcentage">Pourcentage</option><option value="reduction">Reduction</option></select></div></div>';
    text += '<div class="three wide column"><input type="text" placeholder="effet" name="codes_promo[' + num + '][effet]" value=""></div>'
    text += '<div class="three wide column"><input type="text" placeholder="quantite" name="codes_promo[' + num + '][quantite]" value=""></div>'
    text += '<div class="three wide column"><button class="ui fluid basic red button supprtype" data="' + num + '"><i class="trash icon"></i></button></div></div>'

    $("#div_codes_promo").append(text)

    $('select.dropdown').dropdown();

    $(this).attr("code_promo_nb", num)
  });
}
