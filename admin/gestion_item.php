<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/controleur/gestion_item.php");

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
        Gestion Item
      </h2>

      <div class="ui grid">
        <div class="sixteen wide column">
          <div class="ui segment">
            <form id="form_item" class="ui form" action="controleur/traitement_gestion_item.php" method="post" enctype="multipart/form-data">
              <div class="field">
                <label>Titre de l'item</label>
                <input type="text" name="nom" value="<?= ($update) ? $item['nom_item'] : '' ?>">
              </div>
              <div class="field">
                <label>Description</label>
                <textarea name="description" rows="2"><?= ($update) ? $item['description'] : '' ?></textarea>
              </div>
              <div class="field">
                <label>Catégorie</label>
                <select name="categorie" class="ui dropdown" id="select">
                  <option value="">Categorie</option>
                  <?php foreach ($categories as $categorie): ?>
                    <?php if ($update): ?>
                      <option value="<?= $categorie['id'] ?>" <?= ($categorie['nom'] == $item['categorie']) ? 'selected' : '' ?>><?= $categorie['nom'] ?></option>
                    <?php else: ?>
                      <option value="<?= $categorie['id'] ?>"><?= $categorie['nom'] ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label>Prix</label>
                <input type="text" name="prix" value="<?= ($update) ? $item['prix'] : '' ?>">
              </div>
              <div class="field">
                <label>Stock</label>
                <input type="text" name="stock" value="<?= ($update) ? $item['stock'] : '' ?>">
              </div>
              <div class="field">
                <label>Photo</label>
                <?php if ($update): ?>
                  <img class="ui small image" src="/images/<?= $item['photo'] ?>">
                <?php endif; ?>
                <input id="uploadImage" type="file" accept="images/*" name="image" />
              </div>

              <div class="ui segment">
                <div id="parametres">
                  <?php if ($update): ?>
                    <?php foreach ($parametres as $key => $parametre): ?>
                      <div class="suppParam<?= $key ?>">
                        <div class="parametre<?= $key ?>">
                          <h3 class="ui center aligned header">
                            Paramètre <?= $key + 1 ?> <i class="trash icon suppParam" numparam="<?= $key ?>"></i>
                          </h3>
                          <div class="field">
                            <label>Nom</label>
                            <input type="text" name="parametres[<?= $key ?>][nom]" value="<?= $parametre->{'nom'} ?>" placeholder="Nom du paramètre">
                          </div>
                          <?php foreach ($parametre->{'options'} as $key2 => $options): ?>
                            <div id="divoption<?= $key ?><?= $key2 ?>" class="field">
                              <input type="text" name="parametres[<?= $key ?>][options][<?= $key2 ?>]" value="<?= $options ?>">
                              <button class="ui red button suppoption" numparam="<?= $key ?>" numoption="<?= $key2 ?>"><i class="trash icon"></i> Supprimer cette option</button>
                            </div>
                          <?php endforeach; ?>
                        </div>
                        <div class="ui hidden divider"></div>
                        <button class="ui blue button addoption" numparam="0" numoption="<?= ($update) ? sizeof($parametre->{'options'}) : '0' ?>">Ajouter une option</button>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="suppParam0">
                      <div class="parametre0">
                        <h3 class="ui center aligned header">
                          Paramètre 1 <i class="trash icon suppParam" numparam="0"></i>
                        </h3>
                        <div class="field">
                          <label>Nom</label>
                          <input type="text" name="parametres[0][nom]" value="<?= ($update) ? $parametre->{'nom'} : '' ?>" placeholder="Nom du paramètre">
                        </div>
                        <div id="divoption00" class="field">
                          <input type="text" name="parametres[0][options][0]">
                          <button class="ui red button suppoption" numparam="0" numoption="0"><i class="trash icon"></i> Supprimer cette option</button>
                        </div>
                      </div>
                      <div class="ui hidden divider"></div>
                      <button class="ui blue button addoption" numparam="0" numoption="<?= ($update) ? sizeof($parametre->{'options'}) : '0' ?>">Ajouter une option</button>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="ui divider"></div>
                <button class="ui fluid blue button addparam" numparam="<?= ($update) ? sizeof($parametres) : '0' ?>">Ajouter un parametre</button>
              </div>

              <div class="ui hidden divider"></div>
              <div class="ui error message"></div>
              <button class="ui green button" type="submit">Sauvegarder</button>
              <?php if ($update): ?>
                <button class="ui red button trashbutton" type="button" data="<?= $item['id'] ?>">Supprimer cet item</button>
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <?php endif; ?>
              <a class="ui blue button right floated trashbutton" href="/admin/admin.php"><i class="home icon"></i></a>
              <input type="hidden" name="update" value="<?= $update ?>">
            </form>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../semantic/semantic.min.js"></script>
    <script type="text/javascript" src="../js/gestion_item.js"></script>
    <script type="text/javascript">
      $( document ).ready(function() {
        $('#select').dropdown();

        addOption()
        deleteOption()
        deleteParam()

        $(".addparam").click(function(e) {
          e.preventDefault()
          var numparam = $(this).attr("numparam")

          var numparamsupp = parseInt(numparam) + 1;

          var text  = '<div class="ui divider"></div><div class="suppParam' + numparamsupp + '"><div class="parametre' + numparamsupp + '"><h3 class="ui center aligned header">Paramètre ' + (numparamsupp + 1) + ' <i class="trash icon suppParam" numparam="' + numparamsupp + '"></i></h3>';
              text += '<div class="field"><label>Nom</label><input type="text" name="parametres[' + numparamsupp + '][nom]" placeholder="Nom du paramètre"></div>';
              text += '<div id="divoption' + numparamsupp + '0" class="field"><input type="text" name="parametres[' + numparamsupp + '][options][0]">';
              text += '<button class="ui red button suppoption" numparam="' + numparamsupp + '" numoption="0"><i class="trash icon"></i> Supprimer cette option</button></div></div>';
              text += '<div class="ui hidden divider"></div><button class="ui blue button addoption" numparam="' + numparamsupp + '" numoption="0">Ajouter une option</button></div>';

          $("#parametres").append(text)

          $(this).attr("numparam", numparamsupp)
        });

        $('#form_item').form({
          fields: {
            name: {
              identifier: 'nom',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Il manque le nom'
                }
              ]
            },
            description: {
              identifier: 'description',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Il manque la description'
                }
              ]
            },
            categorie: {
              identifier: 'categorie',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Il manque une categorie'
                }
              ]
            },
            prix: {
              identifier: 'prix',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Il manque un prix'
                }
              ]
            },
            stock: {
              identifier: 'stock',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Il manque le stock disponible'
                }
              ]
            }
          }
        });

        $(".trashbutton").click(function() {
          $.ajax({
            type: "POST",
            url: 'controleur/delete_item.php',
            data: {id: $(this).attr('data')},
            success: function(data){
              window.location.replace("/admin/admin.php");
            }
          });
        });
      });
    </script>
  </body>
</html>
