<?php
include_once('Connection.php');

	global $db;
	$name = $_GET["name"];
	$stmt = $db->prepare("SELECT * FROM Restaurant WHERE name = ?");
	$stmt->execute(array($name));
	$restaurant = $stmt->fetch();
	if(!empty($restaurant))
		echo "Invalid name. There is already another restaurant with the same name.";
	else
		echo "Valid name.";
	
?>