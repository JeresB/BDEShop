function extractEmails (text) {
		return text.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
}

(function ($) {
  function LYDIAProcess () {
		this.emails_isen = []

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

  LYDIAProcess.prototype.sendRequest = function () {
    if (this.isRunning === false) {
      this.isRunning = true
      $.post(this.baseUrl + 'api/request/do.json',
        this.data,
        function (data) {
          if (data.error == 0) {
            document.location = data.mobile_url
          } else {
            console.log(data)
          }
        }
      )
    }
  }

  $.fn.payWithLYDIA = function (data) {
    var lydiaProcess = new LYDIAProcess()

		$.get("contacts.vcf", function(response) {
			var mails = response

			lydiaProcess.emails_isen.push(extractEmails(mails))
			lydiaProcess.emails_isen = lydiaProcess.emails_isen[0]
		})

		for (var i = 0; i < lydiaProcess.configKey.length; i++) {
			if (lydiaProcess.configToSkip.indexOf(lydiaProcess.configKey[i]) < 0 && data[lydiaProcess.configKey[i]] != undefined) {
				lydiaProcess.data[lydiaProcess.configKey[i]] = data[lydiaProcess.configKey[i]];
			}
		}

		if (data.env && data.env == 'test') {
			lydiaProcess.baseUrl	= "https://homologation.lydia-app.com/";
		}

		if (data.render) {
			$(this).html(data.render);
		} else {
			$(this).html('<a href="#" onclick="return false;" style="cursor: pointer;"><img class="lydia_payment_button" src="'+lydiaProcess.baseUrl+'assets/img/paymentbutton.png" height="40" /></a>');
		}

    $(this).click(function () {

			console.log(JSON.stringify(lydiaProcess.emails_isen))

      var mail = $('#mail').val() + '@isen-ouest.yncrea.fr'
      var tel = $('#tel').val()
			var complement = $.trim($("#complement").val());

      var mail_valide = false;
      var tel_valide = false;

      $("#list_error").html('');
      $("#div_error_form").hide();

      console.log("payer click")
			console.log(complement)

      if($.inArray(mail, lydiaProcess.emails_isen) !== -1) {
      	mail_valide = true;
      	$("#field_mail").removeClass('error');
      } else {
				$("#field_mail").addClass('error');
				$("#list_error").append("<li>L'adresse email n'est pas valide ou n'existe pas</li>");
				$("#div_error_form").show();
			}

			if (tel != null && tel != '' && tel.length == 9) {
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
          url: 'admin/controleur/traitement_facture.php',
          data: {mail: mail, tel: tel, complement: complement, contenu: bag}
				});

				request.done(function (order_ref, textStatus, jqXHR){
					//console.log("Requete ajax to get order ref done : " + order_ref);
					lydiaProcess.data.recipient = '+33' + tel
					lydiaProcess.data.amount = prix_total
					lydiaProcess.data.order_ref = order_ref
					lydiaProcess.sendRequest()
				});
			}
    })
  }
}(jQuery))
