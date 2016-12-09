<?php
include_once('Connection.php');

// Restaurant Info

	global $db;
	$id = $_GET["id"];
	$name = $_GET["name"];
	$description = $_GET["description"];
	$location = $_GET["location"];
	$contact = $_GET["contact"];
	$avgPrice = $_GET["avgPrice"];
	$schedule = $_GET["schedule"];
	$observation = $_GET["observation"];

	$stmt = $db->prepare("UPDATE Restaurant SET name = ? , description = ? , location = ? , contact = ? , avgPrice = ? , schedule = ? , observation = ? WHERE restaurantId = ?");
	echo $stmt->execute(array($name, $description, $location, $contact, $avgPrice, $schedule, $observation, $id));
?>