<?php

session_start();

error_log(print_r($_POST, true));

$_SESSION["shopping_list"][] = $_POST;

echo json_encode($_SESSION["shopping_list"]);

?>
