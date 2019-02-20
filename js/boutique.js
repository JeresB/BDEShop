function selectParametre() {
  $("#list_items").on( "click", ".parametre_button", function(e) {
    e.preventDefault()

    $('.' + $(this).attr('data')).removeClass('active')
    $(this).addClass('active')
  });
}
