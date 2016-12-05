<?php
include_once('Connection.php');

	global $db;
	$id = $_GET["id"];
	$stmt = $db->prepare("SELECT filename FROM Photo WHERE photoId = ?");
	$stmt->execute(array($id));
	$info = $stmt->fetch();
	
	
	if(!empty($info))
		echo json_encode($info['filename']);
	else
		echo 'INVALID';
?>