<?php
include_once('my_database/restaurant.php');

if (isset ($_GET["name"] ))
    $name = trim(strip_tags($_GET["name"]));
else
    die(header('Location: ' . $_SERVER["HTTP_REFERER"]));

$restaurant = getRestaurantsByName($name);

if(!empty($restaurant))
    echo "Invalid name. There is already another restaurant with the same name.";
else
    echo "Valid name.";

?>
