<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/controleur/gestion_billetterie.php");
require_once("$root/admin/controleur/vendeurs.php");

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
        Gestion Billetterie
      </h2>

      <div class="ui segment">
        <h4 class="ui header">Billetterie<?php if ($update): ?> n° <strong><?= $billetterie['id']; ?></strong><?php endif; ?></h4>

        <form id="form_billetterie" class="ui form" action="controleur/traitement_gestion_billetterie.php" method="post" enctype="multipart/form-data">
          <div class="ui message">
            Pour une quantité infini, il faut mettre -1
          </div>
          <div class="field">
            <label>Titre de la billetterie</label>
            <input type="text" name="nom" value="<?= ($update) ? $billetterie['nom'] : '' ?>">
          </div>

          <div class="field">
            <label>Description</label>
            <textarea id="description" name="description" rows="3" maxlength="8192"><?= ($update) ? $billetterie['description'] : '' ?></textarea>
          </div>

          <div class="field">
            <label>Places total</label>
            <input type="text" name="place_total" value="<?= ($update) ? $billetterie['place_total'] : '' ?>">
          </div>
          <div class="field">
            <label>Places restantes</label>
            <input type="text" name="place_restante" value="<?= ($update) ? $billetterie['place_restante'] : '' ?>">
          </div>

          <div class="ui divider"></div>

          <div class="inline field">
            <div class="ui toggle checkbox">
              <label>Activation Billetterie</label>
              <input type="checkbox" tabindex="0" class="hidden" name="activation" <?php if ($update) { if ($billetterie['active']) { echo 'checked'; }} ?>>
            </div>
          </div>

          <div class="ui divider"></div>

          <div class="field">
            <label>Vendeur</label>
            <select id="vendeur" class="ui dropdown" name="vendeur">
              <option value="">Vendeur</option>
              <?php foreach ($vendeurs as $vendeur): ?>
                <option value="<?= $vendeur['token'] ?>" <?php if($update) { if($vendeur['token'] == $billetterie['token']) { echo 'selected'; }} ?>><?= $vendeur['nom'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="ui divider"></div>

          <div class="field">
            <label>Photo</label>
            <input type="hidden" name="save_photo" value="<?= ($update) ? $billetterie['photo'] : '' ?>">
            <?php if ($update): ?>
              <img class="ui small image" src="/images/<?= $billetterie['photo'] ?>">
            <?php endif; ?>
            <input id="uploadImage" type="file" accept="images/*" name="image" />
          </div>

          <div class="ui divider"></div>

          <div id="types" class="field">
            <label>Type de place</label>

            <div id="div_types">
              <?php foreach ($types as $key => $type): ?>
                <?php $type_num++; ?>
                <div id="type<?= $type_num ?>" class="ui grid">
                  <div class="four wide column">
                    <input type="text" placeholder="nom" name="types[<?= $key ?>][nom]" value="<?= ($update) ? $type->{'nom'} : '' ?>">
                  </div>
                  <div class="three wide column">
                    <input type="text" placeholder="prix" name="types[<?= $key ?>][prix]" value="<?= ($update) ? $type->{'prix'} : '' ?>">
                  </div>
                  <div class="three wide column">
                    <input type="text" placeholder="quantite" name="types[<?= $key ?>][quantite]" value="<?= ($update) ? $type->{'quantite'} : '' ?>">
                  </div>
                  <div class="three wide column">
                    <input type="text" placeholder="place_prise" name="types[<?= $key ?>][place_prise]" value="<?= ($update) ? $type->{'place_prise'} : '' ?>">
                  </div>
                  <div class="three wide column">
                    <button class="ui fluid basic red button supprtype" data="<?= $type_num ?>"><i class="trash icon"></i></button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="ui hidden divider"></div>
            <button class="ui fluid basic blue button addtype" type_nb="<?= $type_num ?>">Ajouter un type de place <i class="plus icon"></i></button>
          </div>

          <div class="ui hidden divider"></div>

          <div id="horaires" class="field">
            <label>Horaires</label>

            <div id="div_horaires">
              <?php foreach ($horaires as $key => $horaire): ?>
                <?php $horaire_num++; ?>
                <div id="horaire<?= $horaire_num ?>" class="ui grid">
                  <div class="four wide column">
                    <input type="text" placeholder="nom" name="horaires[<?= $key ?>][nom]" value="<?= ($update) ? $horaire->{'nom'} : '' ?>">
                  </div>
                  <div class="four wide column">
                    <input type="text" placeholder="quantite" name="horaires[<?= $key ?>][quantite]" value="<?= ($update) ? $horaire->{'quantite'} : '' ?>">
                  </div>
                  <div class="four wide column">
                    <input type="text" placeholder="place_prise" name="horaires[<?= $key ?>][place_prise]" value="<?= ($update) ? $horaire->{'place_prise'} : '' ?>">
                  </div>
                  <div class="four wide column">
                    <button class="ui fluid basic red button supprhoraire" data="<?= $horaire_num ?>"><i class="trash icon"></i></button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="ui hidden divider"></div>
            <button class="ui fluid basic blue button addhoraire" horaire_nb="<?= $horaire_num ?>">Ajouter un horaire <i class="plus icon"></i></button>
          </div>

          <div class="ui hidden divider"></div>

          <div id="codes_promo" class="field">
            <label>Codes Promo</label>

            <div class="ui message">
              3 types de code promo possible :
              <ul class="ui list">
                <li>'reduction' : applique une reduction sur un prix</li>
                <li>'pourcentage' : applique un pourcentage sur un prix</li>
                <li>'prix': modifier le prix avec la valeur donnee</li>
              </ul>
            </div>
            <div id="div_codes_promo">
              <?php foreach ($codes_promo as $key => $code_promo): ?>
                <?php $code_promo_num++; ?>
                <div id="code_promo<?= $code_promo_num ?>" class="ui grid">
                  <div class="four wide column">
                    <input type="text" placeholder="nom" name="codes_promo[<?= $key ?>][nom]" value="<?= ($update) ? $code_promo->{'nom'} : '' ?>">
                  </div>
                  <div class="three wide column">
                    <div class="field">
                      <select id="type_code_promo" class="ui dropdown" name="codes_promo[<?= $key ?>][type]" value="<?= ($update) ? $code_promo->{'type'} : '' ?>">
                        <option value="">Type de code promo</option>
                        <option value="prix" <?php if($update) { if($code_promo->{'type'} == 'prix') { echo 'selected'; }} ?>>Prix</option>
                        <option value="pourcentage" <?php if($update) { if($code_promo->{'type'} == 'pourcentage') { echo 'selected'; }} ?>>Pourcentage</option>
                        <option value="reduction" <?php if($update) { if($code_promo->{'type'} == 'reduction') { echo 'selected'; }} ?>>Reduction</option>
                      </select>
                    </div>
                  </div>
                  <div class="three wide column">
                    <input type="text" placeholder="effet" name="codes_promo[<?= $key ?>][effet]" value="<?= ($update) ? $code_promo->{'effet'} : '' ?>">
                  </div>
                  <div class="three wide column">
                    <input type="text" placeholder="quantite" name="codes_promo[<?= $key ?>][quantite]" value="<?= ($update) ? $code_promo->{'quantite'} : '' ?>">
                  </div>
                  <div class="three wide column">
                    <button class="ui fluid basic red button supprcode_promo" data="<?= $code_promo_num ?>"><i class="trash icon"></i></button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="ui hidden divider"></div>
            <button class="ui fluid basic blue button addcode_promo" code_promo_nb="<?= $code_promo_num ?>">Ajouter un code promo <i class="plus icon"></i></button>
          </div>

          <div class="ui hidden divider"></div>
          <div class="ui error message"></div>
          <div id="erreur"></div>

          <button class="ui green button" type="submit">Sauvegarder</button>

          <?php if ($update): ?>
            <button class="ui red button supprbilletterie" type="button" data="<?= $billetterie['id'] ?>">Supprimer cette billetterie</button>
            <input id="id_billetterie" type="hidden" name="id" value="<?= $billetterie['id'] ?>">
          <?php endif; ?>

          <a class="ui blue button right floated" href="/admin/admin.php"><i class="home icon"></i></a>
          <input type="hidden" name="update" value="<?= $update ?>">
        </form>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../semantic/semantic.min.js"></script>
    <script type="text/javascript" src="../js/gestion_billetterie.js"></script>
    <script type="text/javascript">
      $('.ui.checkbox').checkbox()
      $('select.dropdown').dropdown();

      addType()
      deleteType()

      addHoraire()
      deleteHoraire()

      addCode_Promo()
      deleteCode_Promo()

      $(".supprbilletterie").click(function() {
        $.ajax({
          type: "POST",
          url: 'controleur/get_billetterie_transaction.php',
          data: {id: $("#id_billetterie").val()},
          success: function(data){
            console.log(data);
            if (!(data > 0)) {
              $.ajax({
                type: "POST",
                url: 'controleur/delete_billetterie.php',
                data: {id: $("#id_billetterie").val()},
                success: function(data){
                  window.location.replace("/admin/admin.php");
                }
              });
            } else {
              console.log('coucou');
              var text = '<div class="ui visible error message"><p>Vous ne pouvez pas supprimer cette billetterie, elle est liée à certaines transactions.</p></div><div class="ui hidden divider"></div>'

              $("#erreur").html(text)
            }
          }
        });

      });
    </script>
  </body>
</html>
