<?php
include_once('my_database/user.php');

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

if (isset ($_GET["name"] ))
    $name = trim(strip_tags($_GET["name"]));
else
    $name = NULL;

if (isset ($_GET["email"] ))
    $email = trim(strip_tags($_GET["email"]));
else
    $email = NULL;

if (isset ($_GET["birthdate"] ))
    $birthdate = trim(strip_tags($_GET["birthdate"]));
else
    $birthdate = NULL;

if (isset ($_GET["postCode"] ))
    $postCode = trim(strip_tags($_GET["postCode"]));
else
    $postCode = NULL;

if (isset ($_GET["password"] ))
    $password = trim(strip_tags($_GET["password"]));
else
    $password = NULL;

$options = ['cost' => 12];

addUser($name, $email, $birthdate,$postCode, $username, $password, $options);
?>
