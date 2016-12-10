<?php
//Restaurant Photo 

include_once('Connection.php');

	global $db;

    $val = $_POST['val'];
	$res = $_POST['restaurant'];
	
	$stmt = $db->prepare("SELECT photoId from Photo WHERE filename = ?");
	$stmt->execute(array($val));
	$deleteId = $stmt->fetch();
	$deleteId = $deleteId['photoId'];
	
	$stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
	$stmt->execute(array($deleteId));
		
	unlink("../css/images/$deleteId.jpg");
	unlink("../css/images_small/$deleteId.jpg");
	unlink("../css/images_medium/$deleteId.jpg");
	
	header('Location: ../restaurantProfileEdit.php?restaurant=' . $res);
	exit;
?>