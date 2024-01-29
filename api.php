<?php
header("Access-Control-Alow-Origin: *");
header("Content-Type: application/json ; charset=UTF-8");
header("Access-Control-Allow-Methds: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Alow-Heders: *");
include "connect.php";
include 'includes/functions/functions.php';


$products = getAllFrom('*', 'products');


$purchases =getAllFrom('*', 'my_purchases');


$info = array("products" => $products, "my_purchases" => $purchases);

print_r(json_encode($info));
