(function($) {
  function LYDIAProcess() {

    this.configKey = [
      'vendor_token',
      'amount',
      'recipient',
      'order_ref',
      'browser_success_url',
      'browser_cancel_url',
      'confirm_url',
      'sale_desc',
      'payer_desc',
      'collector_desc',
      'expire_time',
      'end_date',
      'provider_token',
      'payment_recipient',
      'notify_payer',
      'notify_collector',
      'display_conf',
      'payment_method',
      'env',
      'render'
    ]

    this.configToSkip = [
      'env',
      'render'
    ]

    this.data = {
      vendor_token: '',
      amount: '',
      recipient: '',
      order_ref: '',
      browser_success_url: '',
      browser_cancel_url: '',
      confirm_url: '',
      sale_desc: '',
      payer_desc: '',
      collector_desc: '',
      expire_time: '',
      end_date: '',
      provider_token: '',
      payment_recipient: '',
      notify_payer: '',
      notify_collector: '',
      display_conf: '',
      payment_method: 'auto',
      currency: 'EUR',
      type: 'phone'
    }

    this.baseUrl = 'https://lydia-app.com/'
    this.isRunning = false
  }

  LYDIAProcess.prototype.sendRequest = function() {
    console.log("sendRequest");
    if (this.isRunning === false) {
      this.isRunning = true
      $.post(this.baseUrl + 'api/request/do.json',
        this.data,
        function(data) {
          if (data.error == 0) {
            document.location = data.mobile_url
          } else {
            console.log(data)
          }
        }
      )
    }
  }

  $.fn.payWithLYDIA = function(data) {
    var lydiaProcess = new LYDIAProcess()

    for (var i = 0; i < lydiaProcess.configKey.length; i++) {
      if (lydiaProcess.configToSkip.indexOf(lydiaProcess.configKey[i]) < 0 && data[lydiaProcess.configKey[i]] != undefined) {
        lydiaProcess.data[lydiaProcess.configKey[i]] = data[lydiaProcess.configKey[i]];
      }
    }

    if (data.env && data.env == 'test') {
      lydiaProcess.baseUrl = "https://homologation.lydia-app.com/";
    }

    if (data.render) {
      $(this).html(data.render);
    } else {
      $(this).html('<a href="#" onclick="return false;" style="cursor: pointer;"><img class="lydia_payment_button" src="' + lydiaProcess.baseUrl + 'assets/img/paymentbutton.png" height="40" /></a>');
    }

    $(this).click(function() {

      var prix = $('#prix').val()

      var mail = $('#mail').val()
      var tel = '+33' + $('#tel').val()
      var type_place = $('#type_place').val()
      var horaire = $('#horaire').val()
      var nom = $("#nom").val()
      var prenom = $("#prenom").val()
      var promo = $("#promo").val()
      var code_promo = $("#code_promo").val()
      var infos_utile = $.trim($("#infos_utile").val())
      var id_billetterie = $("#id_billetterie").val()

      var mail_valide = false;
      var tel_valide = false;

      $("#list_error").html('');
      $("#div_error_form").hide();

      console.log("payer click")

      var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

      if (emailReg.test(mail)) {
        mail_valide = true;
        $("#field_mail").removeClass('error');
      } else {
        $("#field_mail").addClass('error');
        $("#list_error").append("<li>L'adresse email n'est pas valide ou n'existe pas</li>");
        $("#div_error_form").show();
      }

      if (tel != null && tel != '' && tel.length == 12) {
        tel_valide = true;
        $("#field_tel").removeClass('error');
      } else {
        $("#field_tel").addClass('error');
        $("#list_error").append("<li>Le numéro de téléphone est inexistant ou incorrect</li>");
        $("#div_error_form").show();
      }

      if (mail_valide && tel_valide) {
        request = $.ajax({
          type: 'POST',
          url: 'admin/controleur/traitement_billetterie.php',
          data: {
            mail: mail,
            tel: tel,
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
          //console.log("Requete ajax to get order ref done : " + order_ref);
          lydiaProcess.data.recipient = tel
          lydiaProcess.data.amount = prix
          lydiaProcess.data.order_ref = order_ref

          if (prix > 0) {
            lydiaProcess.sendRequest()
          } else {
            $.ajax({
              url: "http://bde.digital-design.ovh/admin/controleur/success.php",
							type: 'POST',
							data: {
								order_ref: order_ref
							}
						}).done(function() {
              window.location.href = "http://bde.digital-design.ovh/success.php";
            });
          }
        });
      }
    })
  }
}(jQuery))
