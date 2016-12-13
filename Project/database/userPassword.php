<?php
include_once('my_database/user.php');

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
        echo "Password correct";
    }
    else
    {
        echo 'Password incorrect!';
    }
}
?>
