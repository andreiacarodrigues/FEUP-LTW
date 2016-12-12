<?php
include_once('my_database/user.php');
// User Password

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

if (isset ($_GET["password"] ))
    $password = trim(strip_tags($_GET["password"]));
else
    $password = NULL;

$options = ['cost' => 12];

updateUserPassword($password,$options,$username);
?>
