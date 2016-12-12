<?php
include_once('my_database/friends.php');

if (isset ($_GET["sessionUsername"] ))
    $sessionUsername = trim(strip_tags($_GET["sessionUsername"]));
else
    $sessionUsername = NULL;

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

$result = addFriend($sessionUsername, $username);

if($result)
    header('Location: ../userProfile.php?username=' . $username);
else
    echo "INVALID";
?>
