<?php
include_once('my_database/Friends.php');

$sessionUsername = $_GET["sessionUsername"];
$username = $_GET["username"];

$result = addFriend($sessionUsername, $username);

if($result)
    header('Location: ../userProfile.php?username=' . $username);
else
    echo "INVALID";
?>