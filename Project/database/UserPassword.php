<?php
include_once('Connection.php');

global $db;
$username = $_GET["username"];
$password = $_GET["password"];

$stmt = $db->prepare("SELECT password FROM User WHERE username = ?");
$stmt->execute(array($username));
$user = $stmt->fetch();

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