<?php
include_once('my_database/user.php');

// User Info
if (isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["birthdate"]) && isset($_GET["postCode"]) && isset($_GET["username"]) && isset($_GET["previousUsername"]))
{
    $name = trim(strip_tags($_GET["name"]));
    $email = trim(strip_tags($_GET["email"]));
    $birthdate = trim(strip_tags($_GET["birthdate"]));
    $postCode = trim(strip_tags($_GET["postCode"]));
    $username = trim(strip_tags($_GET["username"]));
    $previousUsername = trim(strip_tags($_GET["previousUsername"]));
}
else
    die('ERROR');


if($username != $previousUsername)
{
    session_start();

    if(!empty($_SESSION) && is_array($_SESSION)) {
        foreach($_SESSION as $sessionKey => $sessionValue)
            session_unset($_SESSION[$sessionKey]);
    }
    session_destroy();

    session_start();
    session_regenerate_id(true);

    $_SESSION ["userid"] = $username;
}

updateUser($name, $email, $birthdate, $postCode, $username, $previousUsername);
?>
