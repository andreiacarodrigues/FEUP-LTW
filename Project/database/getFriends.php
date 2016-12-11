<?php
include_once('my_database/friends.php');

$username = $_GET["username"];

$result = getFriends($username);

if(!empty($result))
{
    $friends = array();
    foreach($result as $row) {
        $friends[] = $row['username2'];
    }
    echo json_encode($friends);
}
else
    echo 'NO FRIENDS';
?>
