<?php
include_once('my_database/user.php');

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    die('ERROR');

$info = getUserInfo($username);

if(!empty($info))
    echo 'Username already used!';
else
    echo 'Username accepted!';

?>
