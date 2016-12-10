<?php
include_once('Connection.php');

	global $db;
	$username = $_GET["username"];
	$stmt = $db->prepare("SELECT username2 FROM Friend WHERE username1 = ?");
	$stmt->execute(array($username));
	$result = $stmt->fetchAll();
	
	if(!empty($result))
	{
		$friends = array();
		foreach($result as $row) {
			$friends[] = $row['username2'];
		}
		echo json_encode($friends);
	}
	else
		echo 'NO FRIENDS';
?>