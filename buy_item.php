<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/buy_item.php");
?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/head.php"); ?>
  <?php require_once("$root/templates/nav.php"); ?>

  <body>

    <!-- Valeur récupérées par le javascript plus tard -->
    <input id="prix" type="hidden" name="prix" value="<?= $item['prix'] ?>">
    <input id="id" type="hidden" name="id" value="<?= $item['id'] ?>">
    <input id="message" type="hidden" name="message" value="<?= $item['nom_item'] ?>">

    <div class="ui container">
      <div class="ui segment">
        <div class="ui items centered_block">
          <div class="item">
            <a class="ui tiny image" href="/images/<?= $item['photo'] ?>" target="_blank">
              <img src="/images/<?= $item['photo'] ?>">
            </a>
            <div class="content">
              <div class="header"><?= $item['nom_item'] ?></div>
              <div class="meta">
                <?= $item['categorie'] ?>
              </div>
              <div class="description">
                <p><?= $item['description'] ?></p>
              </div>
              <div class="extra">
                <span class="price">Prix : <?= $item['prix'] ?> €</span>
                <span class="stock">Stock : <?= $item['stock'] ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ui segment">
        <form class="ui form centered_block">
          <div id="field_mail" class="field">
            <label>Mail ISEN</label>
            <div class="ui right labeled input" data-children-count="1">
              <input id="mail" type="text" name="mail" placeholder="prenom.nom" style="width: 40%;">
              <div class="ui label">
                @isen-ouest.yncrea.fr
              </div>
            </div>
          </div>
          <div id="field_tel" class="field">
            <label>Téléphone</label>
            <div class="ui labeled input" data-children-count="1">
              <div class="ui label">
                +33
              </div>
              <input id="tel" type="text" name="tel" placeholder="1 23 45 67 89" maxlength="9">
            </div>
          </div>
          <div class="field">
            <label>Message complémentaire</label>
            <textarea id="complement" rows="3" maxlength="8192"></textarea>
          </div>
          <div id="div_error_form" class="ui error message"><ul id="list_error" class="list"></ul></div>
          <img  id="payer" src="/images/paymentbutton.png" style="max-width: 100%!important;">
        </form>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="semantic/semantic.min.js"></script>
    <script type="text/javascript" src="js/LYDIASDK.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#payer").payWithLYDIA({
          amount: 0, // amount in €
          vendor_token: '56ebe1831f92d126022942',
          recipient: '', //cellphone or email of your client. Leave it like this for your test
          message : "", //object of the payment

          // The client will be redirect to this URL after the payment
          browser_success_url : "bdeshop/success.php",
          // This URL will be called by our server after the payment so you can update the order on your database
          confirm_url : "bdeshop/admin/controleur/success.php"
        });
      });
    </script>
  </body>
</html>
