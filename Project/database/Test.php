<?php
include_once('database/Connection.php');

	global $db;
		$stmt = $db->prepare("SELECT userId, name, email, birthdate, postCode, username, password, photoId FROM User");
		$stmt->execute();
		$users = $stmt->fetchAll();
		echo json_encode($users);	
	
	
?>