<?php
include_once('my_database/friends.php');

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    die('ERROR');

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
