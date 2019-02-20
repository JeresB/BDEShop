<?php

session_start();

error_log("ADD BAG");
error_log(print_r($_GET, true));

if (isset($_GET) && !empty($_GET)) {
  $_SESSION["shopping_list"][] = $_GET;
}

echo json_encode($_SESSION["shopping_list"]);

?>
