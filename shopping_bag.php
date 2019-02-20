<?php

session_start();

$shopping_bag = $_SESSION["shopping_list"];

?>
<div class="ui center aligned segment">
  <h2 class="ui center aligned icon header">
    <i class="shopping basket icon"></i>
    Panier
  </h2>
  <div id="list_shopping" class="ui huge middle aligned divided list">
    <?php foreach ($shopping_bag as $key => $item): ?>
      <div class="item">
        <div class="right floated content">
          <div class="ui red button suppr_item_bag" data="<?= $key ?>"><i class="trash alternate icon" style="margin: auto!important;"></i></div>
        </div>
        <div class="content">
          <div class="header">
            <?= $item['quantite'] ?>
            <?= $item['nom'] ?>
            <?php if (array_key_exists('parametres', $item)): ?>
              |
              <?php foreach ($item['parametres'] as $parametre): ?>
                <?= $parametre['nom'].' : '.$parametre['choix'] ?>
              <?php endforeach; ?>
              |
            <?php endif; ?>
            Pour un prix de <?= $item['prix'] ?> €
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
