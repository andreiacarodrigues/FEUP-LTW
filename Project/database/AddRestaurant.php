<?php
include_once('Connection.php');

	global $db;
	
	$owner = $_GET["owner"];
	$name = $_GET["name"];
	$description = $_GET["description"];
	$location = $_GET["location"];
	$postCode = $_GET["postCode"];
	$schedule = $_GET["schedule"];
	$avgPrice = $_GET["avgPrice"];
	$contact = $_GET["contact"];
	$observation = $_GET["observation"];
	
	$stmt = $db->prepare("SELECT restaurantId FROM Restaurant WHERE name = ?");
	$stmt->execute(array($name));
	$info = $stmt->fetch();
	
	if(empty($info))
	{
		$stmt = $db->prepare("INSERT INTO Restaurant VALUES (null, ?, ?, ?, ?, ? ,?, ?, ?, null, null, 0, 0, ?)");
		echo $stmt->execute(array($name, $description, $location, $postCode,$schedule, $avgPrice, $contact, $observation, $owner));
	}
	else
		echo 'INVALID';
?>