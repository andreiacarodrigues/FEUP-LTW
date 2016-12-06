<?php
include_once('Connection.php');

	global $db;
	
	$id = $_GET["id"];
	$username = $_GET["username"];
	$text = $_GET["text"];
	
	$stmt = $db->prepare("INSERT INTO ReviewReply VALUES (?, ?, ?)");
	$stmt->execute(array($id, $username, $text));
	
	$stmt = $db->prepare('SELECT reviewId,username,text FROM ReviewReply');
    $stmt->execute(array());
    $info = $stmt->fetchAll();
	echo json_encode($info);
?>