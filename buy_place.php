<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/get_billetterie.php");
require_once("$root/admin/controleur/get_promo.php");

if(!isset($_SESSION)) {
  session_start();
}

if (!$billetterie['active'] && !$_SESSION['admin']) {
  header('Location: index.php');
}
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

          <div id="place_disponible" class="ui message">
            Place disponible : <?= $billetterie['place_restante']; ?>
          </div>

          <div class="ui grid">
            <div class="eight wide computer sixteen wide mobile column">
              <div class="field">
                <label>Type de place</label>
                <select id="type_place" class="ui dropdown" name="type_place">
                  <option value="">Type de place</option>
                  <?php foreach ($types as $type): ?>
                    <?php
                      $quantite = ($type->{'quantite'} - $type->{'place_prise'});
                    ?>
                    <option id="<?php echo str_replace(' ','',trim($type->{'nom'})); ?>" value="<?= $type->{'nom'} ?>" <?= ($quantite <= 0) ? 'disabled' : ''; ?> prix="<?= $type->{'prix'} ?>"><?= $type->{'nom'} ?> / Prix : <?= $type->{'prix'} ?></option>
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
                    ?>
                    <option id="<?php echo str_replace(' ','',trim($horaire->{'nom'})); ?>" value="<?= $horaire->{'nom'} ?>" <?= ($quantite <= 0) ? 'disabled' : ''; ?>><?= $horaire->{'nom'} ?></option>
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
                <label>Promo</label>
                <select id="promo" class="ui dropdown" name="promo">
                  <option value="">Promo</option>
                  <?php foreach ($promos as $promo): ?>
                    <option value="<?= $promo['nom'] ?>"><?= $promo['nom'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="eight wide computer sixteen wide mobile column">
              <div id="show_type_place" class="ui message"></div>
              <div id="show_horaire" class="ui message"></div>
            </div>
          </div>

          <?php if ($_SESSION['admin']): ?>
            <div class="ui divider"></div>
            <div class="inline field">
              <span>Non Payé</span>
              <div class="ui toggle checkbox">
                <label>Payé</label>
                <input id="checkbox_paye" type="checkbox" tabindex="0" class="hidden" name="message_payer" checked>
              </div>
            </div>
            <button id="createTransacAdmin" class="ui basic fluid blue button">
              Enregistrer la place en tant que BDE Administrateur
            </button>
            <div class="ui divider"></div>
          <?php endif; ?>

          <div class="field">
            <label>Infos utile</label>
            <textarea id="infos_utile" rows="3" maxlength="8192"><?= ($_SESSION['admin']) ? 'Payé' : ''; ?></textarea>
          </div>

          <div class="field">
            <label>Code Promo</label>
            <input id="code_promo" type="text" name="code_promo" type_promo="" effet="">
          </div>

          <div id="message_code_promo"></div>

          <div class="ui divider"></div>

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

          <div id="div_error_form" class="ui error message"><ul id="list_error" class="list"></ul></div>

          <div class="ui message">
            <ul class="list">
              <li>
                Pour payer par carte bancaire, cliquez sur le bouton Lydia ci-dessous.
              </li>
            </ul>
          </div>

          <div id="message_prix"></div>
          <div id="lock_message"></div>

          <div class="ui divider"></div>

          <img  id="payer" src="/images/paymentbutton.png" style="max-width: 100%!important; cursor: pointer;">

          <input id="lock" type="hidden" value="false">
        </form>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="semantic/semantic.min.js"></script>
    <script type="text/javascript" src="js/Semantic-UI-Alert.js"></script>
    <script type="text/javascript" src="js/buy_place.js"></script>
    <script type="text/javascript" src="js/Lydia_billetterie.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.ui.checkbox').checkbox()
        //$('select.dropdown').dropdown();
        gestion_promo()
        get_places()
        //get_types_place()
        get_horaire()

        $("#checkbox_paye").change(function() {
          if ($("#checkbox_paye").is(':checked')) {
            $("#infos_utile").val($("#infos_utile").val().replace("Non Payé", "Payé"));
          } else {
            $("#infos_utile").val($("#infos_utile").val().replace("Payé", "Non Payé"));
          }
        });

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
