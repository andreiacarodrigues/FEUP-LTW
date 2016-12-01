<?php
include_once('Connection.php');

	global $db;
	$username = $_GET["username"];
	$stmt = $db->prepare("SELECT name, email, birthdate, postCode, photoId FROM User WHERE username = ?");
	$stmt->execute(array($username));
	$info = $stmt->fetch();
	
	if(!empty($info))
		echo 'Username already used!';
	else
		echo 'Username accepted!';
	
?>