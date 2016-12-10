<?php
include_once('Connection.php');

	global $db;
	$search = $_GET["search"];
	
	$stmt = $db->prepare("SELECT restaurantId, name, postCode FROM Restaurant");
	$stmt->execute();
	$result = $stmt->fetchAll();

	if(empty($result))
	{
		echo 'No restaurants match the search.';
		exit;
	}
	$selected_restaurants = array();
	
	foreach($result as $row) {
		$postCode = $row['postCode'];
		
		$zip = substr($postCode,0 4);
		if(preg_match("#$search#i",$zip))
		{
			$selected_restaurants[] = $row['name'];
		}
	}

    echo json_encode($selected_restaurants);
?>