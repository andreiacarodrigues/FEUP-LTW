<?php
include_once('my_database/user.php');

session_start();
session_regenerate_id(true);

if (isset ($_GET["username"] ) && isset ($_GET["password"] ))
{
    $username = trim(strip_tags($_GET["username"]));
    $password = trim(strip_tags($_GET["password"]));
}
else
    die('ERROR');

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
