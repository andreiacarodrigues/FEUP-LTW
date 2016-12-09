﻿<?php
//Restaurant Profile Photo 

include_once('Connection.php');

	global $db;

    $val = $_GET['val'];
	$id = $_GET['id'];
	
	$stmt = $db->prepare("SELECT photoId from Restaurant WHERE name = ?");
	$stmt->execute(array($val));
	$deleteId = $stmt->fetch();
	$deleteId = $deleteId['photoId'];
	
	if($deleteId != 1)
	{
		$stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
		$stmt->execute(array($deleteId));
		
		unlink("../css/images/$deleteId.jpg");
		unlink("../css/images_small/$deleteId.jpg");
		unlink("../css/images_medium/$deleteId.jpg");
	}

	$stmt = $db->prepare("UPDATE Restaurant SET photoId = ? WHERE name = ?");
	$stmt->execute(array($id, $val));

	header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
	exit;
?>