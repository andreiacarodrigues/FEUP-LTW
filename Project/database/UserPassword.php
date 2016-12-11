<?php
include_once('my_database/User.php');

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
        echo "Password correct";
    }
    else
    {
        echo 'Password incorrect!';
    }
}
?>