<?php
include_once('my_database/user.php');
// User Password

$username = $_GET["username"];
$password = $_GET["password"];
$options = ['cost' => 12];

updateUserPassword($password,$options,$username);
?>
