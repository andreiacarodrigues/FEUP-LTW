<?php
//Restaurant Profile Photo 

 include_once('my_database/connection.php');

	global $db;

    $val = $_GET['val'];
	$id = $_GET['id'];
	
	$stmt = $db->prepare("SELECT restaurantId from Restaurant WHERE name = ?");
	$stmt->execute(array($val));
	$restaurantId = $stmt->fetch();
	$restaurantId = $restaurantId['restaurantId'];

	$stmt = $db->prepare("INSERT INTO RestaurantPhoto VALUES(?,?)");
	$stmt->execute(array($id, $restaurantId));

	header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
	exit;
?>