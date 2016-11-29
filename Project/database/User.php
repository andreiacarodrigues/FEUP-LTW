<?php
include_once('database/Connection.php');

	function addUser($username, $name, $email, $postCode, $birthdate, $password, $profilePic)
	{
		global $db;
		$stmt = $db->prepare("INSERT INTO user VALUES (null, ?, ?, ?, ?, ? ,?, ?)");
		return $stmt->execute(array($name, $email, $birthdate, $postCode,$username, $password , $profilePic));
	}

	function getAllUsers()
	{
		global $db;
		$stmt = $db->prepare("SELECT name, email, birthdate, postCode, username, password, photoId FROM User");
		$stmt->execute();
		$users = $stmt->fetchAll();
		return $users;
		/*foreach( $users as $user) {
			echo $user['name'] . ' ' . $user['email'] . ' '.  $user['birthdate']. ' '. $user['postCode']. ' '. $user['username'].' '.$user['photoId'] . '<br>';
		}*/
	}
	
	function getUserInfo($username)
	{
		global $db;
		//$username = $_GET["username"];
		$stmt = $db->prepare("SELECT name, email, birthdate, postCode, photoId FROM User WHERE username = ?");
		$stmt->execute(array($username));
		$info = $stmt->fetch();
		return $info;
		//echo $info['name'] . ' ' . $info['email'] . ' '.  $info['birthdate']. ' '. $info['postCode']. ' '. $username.' '.$info['photoId'];	
	}
	
	function deleteUser($username)
	{
		global $db;
		$stmt = $db->prepare("DELETE FROM User WHERE username = ?");
		return $stmt->execute(array($username));
	}

	function userExists($username, $password)
	{
		global $db;
    
		$stmt = $db->prepare('SELECT * FROM User WHERE username = ? AND password = ?');
		$stmt->execute(array($username, sha1($password)));  
		return $stmt->fetch() !== false;
	}
	
?>