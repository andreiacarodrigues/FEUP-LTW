<?php
include_once('my_database/restaurant.php');

$name = $_GET["name"];

$restaurant = getRestaurantsByName($name);

if(!empty($restaurant))
    echo "Invalid name. There is already another restaurant with the same name.";
else
    echo "Valid name.";

?>
