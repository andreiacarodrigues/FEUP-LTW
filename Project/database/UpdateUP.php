<?php
include_once('my_database/User.php');
// User Password

$username = $_GET["username"];
$password = $_GET["password"];
$options = ['cost' => 12];

updateUserPassword($password,$options,$username);
?>