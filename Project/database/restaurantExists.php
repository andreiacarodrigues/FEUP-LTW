<?php
include_once('my_database/restaurant.php');

if (isset ($_GET["name"] ))
    $name = trim(strip_tags($_GET["name"]));
else
    $name = NULL;

$restaurant = getRestaurantsByName($name);

if(!empty($restaurant))
    echo "Invalid name. There is already another restaurant with the same name.";
else
    echo "Valid name.";

?>
