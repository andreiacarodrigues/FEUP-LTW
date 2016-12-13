<?php
include_once('my_database/friends.php');

if (isset ($_GET["sessionUsername"] ) && isset ($_GET["username"] ))
{
    $sessionUsername = trim(strip_tags($_GET["sessionUsername"]));
    $username = trim(strip_tags($_GET["username"]));
}
else
    die('ERROR');

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
