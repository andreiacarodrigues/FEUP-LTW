<?php
include_once('Connection.php');

	global $db;
	
	$sessionUsername = $_GET["sessionUsername"];
	$username = $_GET["username"];
	
	$stmt = $db->prepare("INSERT INTO Friend VALUES (?, ?)");
	$result = $stmt->execute(array($sessionUsername, $username));

	if($result)
	{
		 header('Location: ../userProfile.php?username=' . $username);
	}
	else
		echo "INVALID";
?>