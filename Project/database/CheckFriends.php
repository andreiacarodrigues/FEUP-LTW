<?php
include_once('my_database/Friends.php');

$sessionUsername = $_GET["sessionUsername"];
$username = $_GET["username"];

$result = getFriends($sessionUsername);

if(!empty($result))
{
    foreach($result as $row) {
        if($username == $row['username2'])
        {
            echo "YES";
            exit;
        }
    }

}
else
    echo "NO";
?>