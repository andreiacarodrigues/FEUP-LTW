﻿<?php
include_once('my_database/friends.php');

if (isset ($_GET["sessionUsername"] ) && isset ($_GET["username"] ))
{
    $sessionUsername = trim(strip_tags($_GET["sessionUsername"]));
    $username = trim(strip_tags($_GET["username"]));
	
	if(!(is_username($username) && is_username($sessionUsername)))
		die('ERROR');
}
else
    die('ERROR');

$result = deleteFriendship($sessionUsername, $username);

if($result)
    header('Location: ../userProfile.php?username=' . $username);
else
    echo "INVALID";
?>
