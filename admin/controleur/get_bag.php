<?php

session_start();

$_SESSION["shopping_list"] = array_values($_SESSION["shopping_list"]);

error_log("GET BAG");
error_log(print_r($_SESSION["shopping_list"], true));

echo json_encode($_SESSION["shopping_list"]);

?>
