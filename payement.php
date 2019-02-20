<div id="lydiaButton">Pay with Lydia</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/LYDIASDK.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#lydiaButton').payWithLYDIA({
      amount: 10.5, // amount in €
      vendor_token: '5c35c33bef7d4553272536',
      recipient: '+33711223344', //cellphone or email of your client. Leave it like this for your test
      message : "Facture 004 pour un t-shirt taille M", //object of the payment
      env: 'test',
      render : '<img src="https://lydia-app.com/assets/img/paymentbutton.png" />', //button image
      // The client will be redirect to this URL after the payment
      browser_success_url : "http://localhost/index.php?order_ref=123",
			// This URL will be called by our server after the payment so you can update the order on your database
      confirm_url : "http://localhost/index.php?order_ref=123"
    });
  });
</script>
<!--https://homologation.lydia-app.com/doc/api/#api-Payment-Init
https://lydia-app.com/integration-->
