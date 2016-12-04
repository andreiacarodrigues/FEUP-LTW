<?php
include_once('Connection.php');

	global $db;
	$username = $_GET["username"];
	$stmt = $db->prepare("SELECT name, email, birthdate, postCode, photoId FROM User WHERE username = ?");
	$stmt->execute(array($username));
	$info = $stmt->fetch();
	
	$infoArray = array(0 => $info['name'],
						1 => $info['email'],
						2 => $info['birthdate'],
						3 => $info['postCode'],
						4 => $info['photoId']);
	if(!empty($info))
		echo json_encode($infoArray);
	else
		echo 'INVALID';
	
?>