<?php
include_once('Connection.php');

	global $db;
	
	$username = $_GET["username"];
	$name = $_GET["name"];
	$email = $_GET["email"];
	$birthdate = $_GET["birthdate"];
	$postCode = $_GET["postCode"];
	$password = $_GET["password"];
	
	 $options = ['cost' => 12];
	
	$stmt = $db->prepare("INSERT INTO user VALUES (null, ?, ?, ?, ?, ? ,?, null)");
	$stmt->execute(array($name, $email, $birthdate, $postCode,$username, password_hash($password, PASSWORD_DEFAULT, $options)));
?>