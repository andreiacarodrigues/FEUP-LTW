<?php
include_once('Connection.php');

// User Info

	global $db;
	$name = $_GET["name"];
	$email = $_GET["email"];
	$birthdate = $_GET["birthdate"];
	$postCode = $_GET["postCode"];
	$username = $_GET["username"];
	$previousUsername = $_GET["previousUsername"];
	
	if($u != $previousUsername)
	{
		session_start();
	
		if(!empty($_SESSION) && is_array($_SESSION)) {
			foreach($_SESSION as $sessionKey => $sessionValue)
			session_unset($_SESSION[$sessionKey]);
		}
		session_destroy();
		
		session_start();
		session_regenerate_id(true);
  
		$_SESSION ["userid"] = $username;
	}
	
	$stmt = $db->prepare("UPDATE User SET name = ? , email = ? , birthdate = ? , postCode = ?, username = ? WHERE username = ?");
	echo $stmt->execute(array($name, $email, $birthdate, $postCode, $username, $previousUsername));
?>