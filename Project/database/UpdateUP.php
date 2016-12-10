<?php
include_once('Connection.php');

// User Password

	global $db;
	$username = $_GET["username"];
	$password = $_GET["password"];
	
	$options = ['cost' => 12];
	
	$stmt = $db->prepare("UPDATE User SET password = ? WHERE username = ?");
	echo $stmt->execute(array(password_hash($password, PASSWORD_DEFAULT, $options) , $username));
	
?>