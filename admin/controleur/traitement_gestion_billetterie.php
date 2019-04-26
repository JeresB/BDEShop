<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/controleur/securite.php");
require_once("$root/admin/modele/billetteries.php");

if (isset($_POST) && !empty($_POST)) {
  $photo = $_POST['save_photo'];

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
        $photo = $photo_name;
      } else {
        error_log('ERROR WHEN UPLOADING FILE');
      }
    } else {
      error_log('EXTENSION NOT VALIDATE');
    }
  } else {
    error_log('FILES DOESN\'T EXIST');
  }

  $update = $_POST['update'];

  $types = json_encode($_POST['types']);
  $horaires = json_encode($_POST['horaires']);
  $codes_promo = json_encode($_POST['codes_promo']);

  if(array_key_exists("activation", $_POST)) {
    $activation = 1;
  } else {
    $activation = 0;
  }

  error_log(print_r($_POST, true));

  $gestion_bdd = new BDD_BILLETTERIES();

  if ($update == 1) {
    $success = $gestion_bdd->update($_POST['id'], $_POST['nom'], $_POST['place_total'], $_POST['place_restante'], $types, $horaires, $codes_promo, $photo, $activation);
  } else {
    $success = $gestion_bdd->add($_POST['nom'], $_POST['place_total'], $_POST['place_restante'], $types, $horaires, $codes_promo, $photo, $activation);
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
