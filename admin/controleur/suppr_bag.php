<?php

session_start();

$key = $_GET['key'];

unset($_SESSION["shopping_list"][$key]);

echo json_encode($_SESSION["shopping_list"]);
?>
