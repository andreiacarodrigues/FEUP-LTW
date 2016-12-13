<?php
include_once('my_database/user.php');

if (isset($_GET["username"]) && isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["birthdate"]) && isset($_GET["postCode"]) && isset($_GET["password"]))
{
    $username = trim(strip_tags($_GET["username"]));
    $name = trim(strip_tags($_GET["name"]));
    $email = trim(strip_tags($_GET["email"]));
    $birthdate = trim(strip_tags($_GET["birthdate"]));
    $postCode = trim(strip_tags($_GET["postCode"]));
    $password = trim(strip_tags($_GET["password"]));
}
else
{
    die(header('Location: ' . $_SERVER["HTTP_REFERER"] ));
}

$options = ['cost' => 12];

addUser($name, $email, $birthdate,$postCode, $username, $password, $options);
?>
