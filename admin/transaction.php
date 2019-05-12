<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/controleur/get_billetterie.php");
require_once("$root/admin/controleur/gestion_transaction.php");
require_once("$root/admin/controleur/get_promo.php");

?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/headAdmin.php"); ?>
  <?php require_once("$root/templates/nav.php"); ?>

  <body>
    <div class="ui container">
      <div class="ui hidden divider"></div>
      <h2 class="ui center aligned icon header">
        <i class="circular settings icon"></i>
        Gestion Transaction
      </h2>

      <div class="ui segment">
        <h4 class="ui header">Transaction n° <strong><?= $transaction['id']; ?></strong> / Billetterie : <strong><?= $billetterie['nom']; ?></strong></h4>

        <form id="form_transaction" class="ui form" action="controleur/traitement_gestion_transaction.php" method="post">
          <input type="hidden" name="old_place" value="<?= $transaction['place']; ?>">
          <input type="hidden" name="old_horaire" value="<?= $transaction['horaire']; ?>">
          <input type="hidden" name="id_billetterie" value="<?= $billetterie['id']; ?>">

          <div class="two fields">
            <div class="field">
              <label>Téléphone</label>
              <input type="text" name="tel" value="<?= $transaction['tel']; ?>">
            </div>
            <div class="field">
              <label>Email</label>
              <input type="text" name="mail" value="<?= $transaction['mail']; ?>">
            </div>
          </div>

          <div class="three fields">
            <div class="field">
              <label>Nom</label>
              <input type="text" name="nom" value="<?= $transaction['nom']; ?>">
            </div>
            <div class="field">
              <label>Prenom</label>
              <input type="text" name="prenom" value="<?= $transaction['prenom']; ?>">
            </div>
            <div class="field">
              <label>Promo</label>
              <select id="promo" class="ui dropdown" name="promo" value="<?= $transaction['promo']; ?>">
                <option value="">Promo</option>
                <?php foreach ($promos as $promo): ?>
                  <option value="<?= $promo['id'] ?>" <?php if($promo['id'] == $transaction['promo']) echo 'selected'; ?>><?= $promo['nom'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
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
                <option id="<?= $type->{'nom'} ?>" value="<?= $type->{'nom'} ?>" prix="<?= $type->{'prix'} ?>" <?php if($type->{'nom'} == $transaction['place']) echo 'selected'; ?>><?= $type->{'nom'} ?> / Prix : <?= $type->{'prix'} ?> / Quantité restante : <?= $quantite ?></option>
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
                <option value="<?= $horaire->{'nom'} ?>" <?php if($horaire->{'nom'} == $transaction['horaire']) echo 'selected'; ?>><?= $horaire->{'nom'} ?> / Quantité restante : <?= $quantite ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label>Code promo</label>
            <select id="code_promo" class="ui dropdown" name="code_promo">
              <option value="">Code promo</option>
              <?php foreach ($codes_promo as $code_promo): ?>
                <option value="<?= $code_promo->{'nom'} ?>" <?php if($code_promo->{'nom'} == $transaction['code_promo']) echo 'selected'; ?>><?= $code_promo->{'nom'} ?> / Type : <?= $code_promo->{'type'} ?> / Effet <?= $code_promo->{'effet'} ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="two fields">
            <div class="field">
              <label>Infos utile</label>
              <input type="text" name="infos_utile" value="<?= $transaction['infos_utile']; ?>">
            </div>
            <div class="field">
              <label>Status</label>
              <input type="text" name="status" value="<?= $transaction['status']; ?>">
            </div>
          </div>

          <div class="ui hidden divider"></div>
          <div class="ui error message"></div>
          <div id="erreur"></div>

          <button class="ui green button" type="submit">Sauvegarder</button>

          <button class="ui red button supprtransaction" type="button" data="<?= $transaction['id'] ?>">Supprimer cette transaction</button>
          <input id="id_transaction" type="hidden" name="id" value="<?= $transaction['id'] ?>">

          <a class="ui blue button right floated" href="/admin/transactions.php"><i class="home icon"></i></a>
        </form>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../semantic/semantic.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('select.dropdown').dropdown();

        $(".supprtransaction").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/delete_transaction.php',
            data: {id: $("#id_transaction").val(), billetterie: $("#id_billetterie").val()},
            success: function(data){
              history.back();
            }
          });
        });
      });
    </script>
  </body>
</html>
