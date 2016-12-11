<?php
include_once('my_database/User.php');

$username = $_GET["username"];
$name = $_GET["name"];
$email = $_GET["email"];
$birthdate = $_GET["birthdate"];
$postCode = $_GET["postCode"];
$password = $_GET["password"];

$options = ['cost' => 12];

addUser($name, $email, $birthdate,$postCode, $username, $password, $options);
?>