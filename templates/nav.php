<div class="ui grid">
  <div class="computer tablet only row">
    <div class="column">
      <nav class="ui massive menu">
        <div class="header item">
          BDE Cosmunity
        </div>
        <a class="item" href="/">
          Accueil
        </a>
        <a class="item" href="/boutique.php">
          Boutique
        </a>
        <a class="item" href="/billetterie.php">
          Billetterie
        </a>
        <?php
          if(!isset($_SESSION)) {
            session_start();
          }
          if (array_key_exists("admin", $_SESSION) && $_SESSION['admin']) {
            echo '<a class="item" href="/admin/admin.php">
              Accueil Admin
            </a>';
          }
        ?>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="mobile only column">
      <nav class="ui massive menu">
        <div class="header item">
          BDE Cosmunity
        </div>
        <a class="item" href="/">
          <i class="home icon"></i>
        </a>
        <a class="item" href="/boutique.php">
          <i class="shopping cart icon"></i>
        </a>
        <a class="item" href="/billetterie.php">
          <i class="ticket alternate icon"></i>
        </a>
      </nav>
    </div>
  </div>
</div>
