
<?php
include_once('Connection.php');

	global $db;
	$username = $_POST["username"];
	$name = $_POST["name"];
	$email = $_POST["email"];
	$postCode = $_POST["postCode"];
	$birthdate = $_POST["birthdate"];
	$password = $_POST["password"];
	$profilePic = $_POST["profilePic"];
	
	// Insert Message
	$stmt = $db->prepare("INSERT INTO user VALUES (null, ?, ?, ?, ?, ? ,?, ?)");
	$stmt->execute(array($name, $email, $birthdate, $postCode,$username, $password , $profilePic));
	
	$stmt = $db->prepare("SELECT * FROM user");
	$stmt->execute();
	$messages = $stmt->fetchAll();
	echo json_encode($messages);

?>