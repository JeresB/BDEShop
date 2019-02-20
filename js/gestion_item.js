function deleteOption() {
  $("#parametres").on( "click", ".suppoption", function(e) {
    e.preventDefault()

    var numoption = $(this).attr("numoption")
    var numparam = $(this).attr("numparam")

    $("#divoption" + numparam + numoption).html("")
  });
}

function addOption() {
  $("#parametres").on( "click", ".addoption", function(e) {
    e.preventDefault()

    var numoption = $(this).attr("numoption")
    var numparam = $(this).attr("numparam")

    var numsupp = parseInt(numoption) + 1

    var text = '<div id="divoption' + numparam + numsupp + '" class="field"><input type="text" name="parametres[' + numparam + '][options][' + numsupp + ']" value="" placeholder="Option ' + numsupp + '"><button class="ui red button suppoption" numparam="' + numparam + '" numoption="' + numsupp + '"><i class="trash icon"></i> Supprimer cette option</button></div>';

    $(".parametre" + numparam).append(text)

    $(this).attr("numoption", numsupp)
  });
}

function deleteParam() {
  $("#parametres").on( "click", ".suppParam", function(e) {
    e.preventDefault()

    var numparam = $(this).attr("numparam")

    $(".suppParam" + numparam).remove()
  });
}
