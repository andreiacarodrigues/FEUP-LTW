<?php
include_once('Connection.php');

	global $db;
	$restaurant = $_GET["restaurant"];

	$stmt = $db->prepare('SELECT restaurantId FROM Restaurant WHERE name = ?');
	$stmt->execute(array($restaurant));
	$restaurantId = $stmt->fetch();

	
	$stmt = $db->prepare('SELECT photoId FROM RestaurantPhoto WHERE restaurantId = ?');
	$stmt->execute(array($restaurantId['restaurantId']));
	$photos = $stmt->fetchAll();
	
	$result = array();
	foreach ($photos as $photo)
	{
		$stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
		$stmt->execute(array($photo['photoId']));
		$photo = $stmt->fetch();
		$result[] = $photo['filename'];
	}
	
	if(!empty($result))
		echo json_encode($result);
	else
		echo 'INVALID';
?>