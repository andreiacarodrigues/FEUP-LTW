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
