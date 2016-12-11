<?php
include_once('my_database/user.php');

session_start();
session_regenerate_id(true);

$username = $_GET["username"];
$password = $_GET["password"];

$user = getUserPassword($username);

if(empty($user))
    echo "Username doesn't exist!";
else
{
    $verify = password_verify ($password , $user['password']);

    if($verify)
    {
        $_SESSION ["userid"] = $username;
        echo "VALID";
    }
    else
    {
        echo 'Password incorrect!';
    }
}

?>
