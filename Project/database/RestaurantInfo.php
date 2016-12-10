<?php
include_once('Connection.php');

	global $db;
	$restaurant = $_GET["restaurant"];
	$stmt = $db->prepare("SELECT restaurantId, description, location, contact, avgPrice, schedule, observation, menuId, photoId, rating_sum, rating_total, owner FROM Restaurant WHERE name = ?");
	$stmt->execute(array($restaurant));
	$info = $stmt->fetch();
	
	if(!empty($info))
	{
		$infoArray = array(0 => $info['restaurantId'],
						1 => $info['description'],
						2 => $info['location'],
						3 => $info['contact'],
						4 => $info['avgPrice'],
						5 => $info['schedule'],
						6 => $info['observation'],
						7 => $info['menuId'],
						8 => $info['photoId'],
						9 => $info['rating_sum'],
						10 => $info['rating_total'],
						11 => $info['owner']
						);
						
		echo json_encode($infoArray);
	}
	else
		echo 'INVALID';
	
?>