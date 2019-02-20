<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/items.php");

if (isset($_POST) && !empty($_POST)) {
  $update = $_POST['update'];
  $insert_with_picture = false;

  if (isset($_FILES) && !empty($_FILES) && $_FILES['image']['name'] != '') {
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf');
    $uploadfolder = $_SERVER['DOCUMENT_ROOT']."/images/";

    $photo_name = $_FILES['image']['name'];
    $photo_tmp_name = $_FILES['image']['tmp_name'];

    // get uploaded file's extension
    $ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));

    // check's valid format
    if (in_array($ext, $valid_extensions)) {
      if (move_uploaded_file($photo_tmp_name, $uploadfolder.$photo_name)) {
        $insert_with_picture = true;
      } else {
        echo 'ERROR WHEN UPLOADING FILE';
      }
    } else {
      echo 'EXTENSION NOT VALIDATE';
    }
  } else {
    echo 'FILES DOESN\'T EXIST';
  }

  $parametre_json = json_encode($_POST['parametres']);

  error_log(print_r($parametre_json, true));

  $gestion_bdd = new BDD_ITEMS();

  if ($update == 1) {
    if ($insert_with_picture) {
      $success = $gestion_bdd->updateWithPicture($_POST['id'], $_POST['nom'], $_POST['stock'], $_POST['prix'], $_POST['description'], $photo_name, $parametre_json, $_POST['categorie']);
    } else {
      $success = $gestion_bdd->update($_POST['id'], $_POST['nom'], $_POST['stock'], $_POST['prix'], $_POST['description'], $parametre_json, $_POST['categorie']);
    }

  } else {
    if ($insert_with_picture) {
      $success = $gestion_bdd->addWithPicture($_POST['nom'], $_POST['stock'], $_POST['prix'], $_POST['description'], $photo_name, $parametre_json, $_POST['categorie']);
    } else {
      $success = $gestion_bdd->add($_POST['nom'], $_POST['stock'], $_POST['prix'], $_POST['description'], $parametre_json, $_POST['categorie']);
    }
  }

  echo '<script type="text/javascript">
          window.location.replace("/admin/admin.php");
        </script>';

} else {
  echo '<script type="text/javascript">
          window.location.replace("/admin/admin.php");
        </script>';
}
?>
