<?php
//Restaurant Profile Photo 

 include_once('my_database/connection.php');

	global $db;

    if(isset($_GET["id"]) && isset($_GET["val"]))
    {
        $id = trim(strip_tags($_GET["id"]));
        $val = trim(strip_tags($_GET["val"]));
    }
    else
        die(header('Location: ' . $_SERVER["HTTP_REFERER"]));
	
	$stmt = $db->prepare("SELECT restaurantId from Restaurant WHERE name = ?");
	$stmt->execute(array($val));
	$restaurantId = $stmt->fetch();
	$restaurantId = $restaurantId['restaurantId'];

	$stmt = $db->prepare("INSERT INTO RestaurantPhoto VALUES(?,?)");
	$stmt->execute(array($id, $restaurantId));

	header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
	exit;
?>