<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/get_billetterie.php");
require_once("$root/admin/controleur/get_promo.php");
?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/head.php"); ?>
  <?php require_once("$root/templates/nav.php"); ?>

  <body>
    <div class="ui container">

      <div class="ui segment">
        <img class="ui fluid rounded image" src="/images/<?= $billetterie['photo']; ?>" alt="Photo billetterie">

        <div class="ui message">
          <div class="header">
            <?= $billetterie['nom']; ?>
          </div>
          <p><?= $billetterie['description']; ?></p>
        </div>

        <input id="id_billetterie" type="hidden" name="id_billetterie" value="<?= $billetterie['id']; ?>">
        <input id="prix" type="hidden" name="prix">

        <form id="formulaire_billetterie" class="ui form centered_block">

          <div class="ui message">
            Place disponible : <?= $billetterie['place_restante']; ?>
          </div>


          <div class="field">
            <label>Type de place</label>
            <select id="type_place" class="ui dropdown" name="type_place">
              <option value="">Type de place</option>
              <?php foreach ($types as $type): ?>
                <?php
                  $quantite = ($type->{'quantite'} - $type->{'place_prise'});
                  if ($quantite < 0) {
                    $quantite = 'infini';
                  }
                ?>
                <option id="<?= $type->{'nom'} ?>" value="<?= $type->{'nom'} ?>" <?= ($quantite === 0) ? 'disabled' : ''; ?> prix="<?= $type->{'prix'} ?>"><?= $type->{'nom'} ?> / Prix : <?= $type->{'prix'} ?> / Quantité restante : <?= $quantite ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="field">
            <label>Horaire navette</label>
            <select id="horaire" class="ui dropdown" name="horaire">
              <option value="">Horaire navette</option>
              <?php foreach ($horaires as $horaire): ?>
                <?php
                  $quantite = ($horaire->{'quantite'} - $horaire->{'place_prise'});
                  if ($quantite < 0) {
                    $quantite = 'infini';
                  }
                ?>
                <option value="<?= $horaire->{'nom'} ?>" <?= ($quantite === 0) ? 'disabled' : ''; ?>><?= $horaire->{'nom'} ?> / Quantité restante : <?= $quantite ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div id="field_mail" class="field">
            <label>Mail</label>
            <input id="mail" type="text" name="mail">
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

          <!-- <div class="field">
            <label>Nombre de places</label>
            <input id="nb_place" type="number" name="nb_place">
          </div> -->

          <div class="ui divider"></div>

          <div id="personnes"></div>

          <div class="field">
            <label>Promo</label>
            <select id="promo" class="ui dropdown" name="promo">
              <option value="">Promo</option>
              <?php foreach ($promos as $promo): ?>
                <option value="<?= $promo['id'] ?>"><?= $promo['nom'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="field">
            <label>Nom</label>
            <input id="nom" type="text" name="nom">
          </div>

          <div class="field">
            <label>Prénom</label>
            <input id="prenom" type="text" name="prenom">
          </div>

          <div class="field">
            <label>Code Promo</label>
            <input id="code_promo" type="text" name="code_promo" type_promo="" effet="">
          </div>

          <div id="message_code_promo"></div>

          <div class="field">
            <label>Infos utile</label>
            <textarea id="infos_utile" rows="3" maxlength="8192"></textarea>
          </div>

          <div id="div_error_form" class="ui error message"><ul id="list_error" class="list"></ul></div>

          <div class="ui message">
            <ul class="list">
              <li>
                Pour payer par carte bancaire, cliquez sur le bouton Lydia ci-dessous.
              </li>
            </ul>
          </div>

          <div id="message_prix"></div>

          <div class="ui divider"></div>

          <img  id="payer" src="/images/paymentbutton.png" style="max-width: 100%!important; cursor: pointer;">

        </form>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="semantic/semantic.min.js"></script>
    <script type="text/javascript" src="js/buy_place.js"></script>
    <script type="text/javascript" src="js/Lydia_billetterie.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('select.dropdown').dropdown();

        gestion_promo()

        $("#type_place").change(function() {
          gestion_prix()
        });
        //setFormPeople()

        $("#payer").payWithLYDIA({
          amount: 0, // amount in €
          //vendor_token: '5c1a1463e1bde447906484', // Token de test
          vendor_token: '56ebe1831ba12038111497',
          recipient: '', //cellphone or email of your client. Leave it like this for your test
          message : "Achat BDE ISEN Billetterie", //object of the payment
          //env: "test", // Only for test
          currency: 'EUR',
          type: 'phone',
          // The client will be redirect to this URL after the payment
          browser_success_url : "http://bde.digital-design.ovh/success.php",
          // This URL will be called by our server after the payment so you can update the order on your database
          confirm_url : "http://bde.digital-design.ovh/admin/controleur/success_billetterie.php"
        });
      });
    </script>
  </body>
</html>
