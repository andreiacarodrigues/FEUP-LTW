<?php
include_once('Connection.php');

	global $db;
	$search = $_GET["search"];
	
	$stmt = $db->prepare("SELECT restaurantId, name FROM Restaurant");
	$stmt->execute();
	$result = $stmt->fetchAll();

	if(empty($result))
	{
		echo 'No restaurants match the search.';
		exit;
	}
	$selected_restaurants = array();
	
	foreach($result as $row) {
		$name = $row['name'];
		if(preg_match("#$search#i",$name))
		{
			$selected_restaurants[] = $name;
		}
	}

    echo json_encode($selected_restaurants);
?>