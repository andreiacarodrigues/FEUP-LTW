<?php
include_once('my_database/Restaurant.php');

$name = $_GET["name"];

/*
    $stmt = $db->prepare("SELECT * FROM Restaurant WHERE name = ?");
    $stmt->execute(array($name));
    return $stmt->fetch();
 */
$restaurant = getRestaurantsByName($name);

if(!empty($restaurant))
    echo "Invalid name. There is already another restaurant with the same name.";
else
    echo "Valid name.";

?>