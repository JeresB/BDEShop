<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/billetteries.php");
?>

<!doctype html>
<html lang="fr">

  <?php require_once("$root/templates/head.php"); ?>
  <?php require_once("$root/templates/nav.php"); ?>

  <body>
    <div class="ui container">
      <h2 class="ui center aligned icon header">
        <i class="ticket alternate icon"></i>
        Billetterie
      </h2>

      <div class="ui raised segment">
        <h4 class="ui center aligned header">
          Liste des billetteries ouvertes
        </h4>
        <div class="ui hidden divider"></div>
        <div class="ui three stackable cards">
          <?php foreach ($billetteries as $billetterie): ?>
            <?php if ($billetterie['active'] && $billetterie['place_restante'] > 0): ?>
              <div class="ui card">
                <div class="image">
                  <img src="/images/<?= $billetterie['photo']; ?>" style="padding-bottom: 10px;">
                </div>
                <div class="content">
                  <div class="header"><?= $billetterie['nom']; ?></div>
                  <div class="description">
                    <?= $billetterie['place_restante']; ?> / <?= $billetterie['place_total']; ?> Places restantes
                  </div>
                </div>
                <div class="extra content">
                  <a class="ui basic blue button" href="buy_place.php?id=<?= $billetterie['id']; ?>">Prendre sa place</a>
                </div>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="semantic/semantic.min.js"></script>
  </body>
</html>
