<?php
include_once('my_database/restaurant.php');

$owner = $_GET["owner"];
$name = $_GET["name"];
$description = $_GET["description"];
$location = $_GET["location"];
$postCode = $_GET["postCode"];
$schedule = $_GET["schedule"];
$avgPrice = $_GET["avgPrice"];
$contact = $_GET["contact"];
$observation = $_GET["observation"];

$info = getRestaurantId($name);

if(empty($info))
    addRestaurant($name,$description,$location,$postCode,$schedule,$avgPrice,$contact,$observation,$owner); //tinha echo
else
    echo 'INVALID';
?>
