<?php
if(!isset($_SESSION)) {
  session_start();
  if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    header('Location: admin.php');
  }
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui">

    <link rel="canonical" href="http://bde.digital-design.ovh/" />
    <link rel="icon" type="image/jpg"  href="/images/bdecosmu.jpg">

    <title>ADMIN | BDE Cosmunity</title>
    <meta name="description" content="" />
    <meta name="keywords" content="">

    <link rel="stylesheet" type="text/css" href="../css/loginadmin.css" />
  </head>
  <body>
    <form class="login" method="post" action="controleur/login.php">
      <label for="login"><?= isset($_GET['text']) ? $_GET['text'] : '' ?></label>
      <input type="text" name="login" placeholder="Nom d'utilisateur">
      <input type="password" name="pass" placeholder="Mot de passe">
      <button>Connexion</button>
    </form>
  </body>
</html>
