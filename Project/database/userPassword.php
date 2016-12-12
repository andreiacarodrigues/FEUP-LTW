<?php
include_once('my_database/user.php');

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
        echo "Password correct";
    }
    else
    {
        echo 'Password incorrect!';
    }
}
?>
