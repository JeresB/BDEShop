<?php

session_start();

$key = $_GET['key'];

error_log("SUPPR BAG");
error_log($key);

unset($_SESSION["shopping_list"][$key]);

$_SESSION["shopping_list"] = array_values($_SESSION["shopping_list"]);

error_log(print_r($_SESSION["shopping_list"], true));

echo json_encode($_SESSION["shopping_list"]);
?>
