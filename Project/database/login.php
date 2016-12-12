<?php
include_once('my_database/user.php');

session_start();
session_regenerate_id(true);

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

if (isset ($_GET["password"] ))
    $password = trim(strip_tags($_GET["password"]));
else
    $password = NULL;

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
