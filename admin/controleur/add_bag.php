<?php

session_start();

error_log("ADD BAG");
error_log(print_r($_GET, true));

if (isset($_GET) && !empty($_GET)) {
  $_SESSION["shopping_list"][] = $_GET;
}

$_SESSION["shopping_list"] = array_values($_SESSION["shopping_list"]);

error_log("ADD BAG");
error_log(print_r($_SESSION["shopping_list"], true));

echo json_encode($_SESSION["shopping_list"]);

?>
