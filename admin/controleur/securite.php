<?php

if(!isset($_SESSION)) {
  session_start();
}

if (!$_SESSION['admin']) {
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  header("Location: $root/admin/index.php?text=Veuillez vous connecter !");
}

?>
