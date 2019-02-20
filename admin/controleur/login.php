<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/admin/modele/login.php");

session_start();

$gestion_bdd = new BDD();

// Déclaration des constantes
define('PREFIX_SALT', 'FT(8x5<rc6R}');
define('SUFFIX_SALT', '8d*d5XU&.C2v');

$hashSecure = md5(PREFIX_SALT.$_POST['pass'].SUFFIX_SALT);

$resultat = $gestion_bdd->connexion($_POST['login'], $hashSecure);

if(isset($resultat) && $resultat != false) {
	$_SESSION['admin'] = true;
	$_SESSION['rang'] = $resultat['rang'];

	header('Location: ../admin.php');
} else {
	$_SESSION['admin'] = false;

	header('Location: ../index.php?text=Nom d\'utilisateur ou mot de passe incorrect !');
}

?>
