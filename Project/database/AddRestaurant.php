<?php
include_once('my_database/Restaurant.php');

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
{
    echo addRestaurant($name,$description,$location,$postCode,$schedule,$avgPrice,$contact,$observation,$owner);
}
else
    echo 'INVALID';
?>