<?php
include_once('Connection.php');

		global $db;
		$username = $_GET["username"];
		$stmt = $db->prepare("SELECT name, email, birthdate, postCode, photoId FROM User WHERE username = ?");
		$stmt->execute($username);
		$info = $stmt->fetch();
		//return $info;
		echo $info['name'] . ' ' . $info['email'] . ' '.  $info['birthdate']. ' '. $info['postCode']. ' '. $username.' '.$info['photoId'];	
		
		/*global $db;
		$stmt = $db->prepare("SELECT userId, name, email, birthdate, postCode, username, password, photoId FROM User");
		$stmt->execute();
		$users = $stmt->fetchAll();
		
		foreach( $users as $user) {
			echo $user['name'] . ' ' . $user['email'] . ' '.  $user['birthdate']. ' '. $user['postCode']. ' '. $user['username'].' '.$user['photoId'] . '<br>';
		}*/
?>