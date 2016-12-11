<?php
include_once('my_database/Restaurant.php');

// Restaurant Info

$id = $_GET["id"];
$name = $_GET["name"];
$description = $_GET["description"];
$location = $_GET["location"];
$postCode = $_GET["postCode"];
$contact = $_GET["contact"];
$avgPrice = $_GET["avgPrice"];
$schedule = $_GET["schedule"];
$observation = $_GET["observation"];

updateRestaurant($name, $description, $location, $contact, $avgPrice, $schedule, $observation, $postCode, $id);
?>