<?php
include_once('Connection.php');

session_start();
session_regenerate_id(true);
  
	global $db;
	$username = $_GET["username"];
	$password = $_GET["password"];
	
	$stmt = $db->prepare("SELECT password FROM User WHERE username = ?");
	$stmt->execute(array($username));

	$user = $stmt->fetch();
	if(empty($user))
		echo "Username doesn't exist!";
	else
	{
		$verify = password_verify ($password , $user['password']);
		
		if($verify)
		{ 
			$_SESSION ["userid"] = $username;
			echo "VALID";
		}
		else
		{
			echo 'Password incorrect!';
		}
	}

?>