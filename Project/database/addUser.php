<?php
include_once('my_database/user.php');

if (isset($_GET["username"]) && isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["birthdate"]) && isset($_GET["postCode"]) && isset($_GET["location"]) && isset($_GET["password"]))
{
    $username = trim(strip_tags($_GET["username"]));
    $name = trim(strip_tags($_GET["name"]));
    $email = trim(strip_tags($_GET["email"]));
    $birthdate = trim(strip_tags($_GET["birthdate"]));
    $postCode = trim(strip_tags($_GET["postCode"]));
	$location = trim(strip_tags($_GET["location"]));
    $password = trim(strip_tags($_GET["password"]));
	
	if(!(is_username($username) && is_email($email) && is_postCode($postCode) && is_text($location) && is_password($password)))
		die('ERROR');
}
else
{
    die('ERROR');
}

$options = ['cost' => 12];

addUser($name, $email, $birthdate,$postCode, $location, $username, $password, $options);
?>
