<?php
include_once('my_database/user.php');

// User Info
if (isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["birthdate"]) && isset($_GET["postCode"]) && isset($_GET["location"]) && isset($_GET["username"]) )
{
    $name = trim(strip_tags($_GET["name"]));
    $email = trim(strip_tags($_GET["email"]));
    $birthdate = trim(strip_tags($_GET["birthdate"]));
    $postCode = trim(strip_tags($_GET["postCode"]));
	$location = trim(strip_tags($_GET["location"]));
    $username = trim(strip_tags($_GET["username"]));
   
	
	if(!(is_username($username) && is_email($email) && is_postCode($postCode) && is_text($location) ))
		die('ERROR');
}
else
    die('ERROR');


updateUser($name, $email, $birthdate, $postCode, $location, $username);
?>
