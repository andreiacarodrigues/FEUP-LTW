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

	/*function userExists($username, $password)
	{
		global $db;
    
		$stmt = $db->prepare('SELECT * FROM User WHERE username = ? AND password = ?');
		$stmt->execute(array($username, sha1($password)));  
		return $stmt->fetch() !== false;
	}*/
	
	function userExists($username)
	{
		global $db;
    
		$stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
		$stmt->execute(array($username));  
		return $stmt->fetch() !== false;
	}

    function getUserPhoto($userPhotoId)
    {
        global $db;

        $stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
        $stmt->execute(array($userPhotoId));
        return $stmt->fetch();
    }

    function getAllReviews($username)
    {
        global $db;

        $stmt = $db->prepare('SELECT reviewId, restaurantId, rating, text FROM Review WHERE username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }

    function getRestaurantInfo($restId)
    {
        global $db;

        $stmt = $db->prepare('SELECT name, location, photoId, rating_total FROM Restaurant WHERE restaurantId = ?');
        $stmt->execute(array($restId));
        return $stmt->fetch();
    }

    function getPhotoFromUserToRest($restId,$username)
    {
        global $db;

        $stmt = $db->prepare('SELECT photoID FROM ReviewPhoto WHERE restaurantId = ? AND username = ?');
        $stmt->execute(array($restId,$username));
        return $stmt->fetch();
    }

    function getPhotoPath($photoId)
    {
        global $db;

        $stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
        $stmt->execute(array($photoId));
        return $stmt->fetch();
    }

    function getAllRestaurantsOwner($username)
    {
        global $db;

        $stmt = $db->prepare('SELECT restaurantId FROM Restaurant WHERE ownerId = ?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }

    function isOwner($username)
    {
        global $db;

        $stmt = $db->prepare('SELECT restaurantId FROM Restaurant WHERE ownerId = ?');
        $stmt->execute(array($username));
        return $stmt->fetch() !== false;    //retorna true se for owner
    }
	
?>