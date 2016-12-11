<?php
include_once('my_database/Friends.php');

$sessionUsername = $_GET["sessionUsername"];
$username = $_GET["username"];

$result = deleteFriendship($sessionUsername, $username);

if($result)
    header('Location: ../userProfile.php?username=' . $username);
else
    echo "INVALID";
?>