<?php
 include_once('my_database/connection.php');

// User Password

	global $db;

    if(isset($_GET["username"]) && isset($_GET["password"]))
    {
        $username = trim(strip_tags($_GET["username"]));
        $password = trim(strip_tags($_GET["password"]));
    }
    else
        die(header('Location: ' . $_SERVER["HTTP_REFERER"]));

	
	$options = ['cost' => 12];
	
	$stmt = $db->prepare("UPDATE User SET password = ? WHERE username = ?");
	echo $stmt->execute(array(password_hash($password, PASSWORD_DEFAULT, $options) , $username));
	
?>