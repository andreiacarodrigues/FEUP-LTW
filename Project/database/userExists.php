<?php
include_once('my_database/user.php');

$username = $_GET["username"];

$info = getUserInfo($username);

if(!empty($info))
    echo 'Username already used!';
else
    echo 'Username accepted!';

?>
