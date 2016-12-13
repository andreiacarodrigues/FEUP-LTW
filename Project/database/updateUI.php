<?php
include_once('my_database/user.php');

// User Info
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

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

if (isset ($_GET["previousUsername"] ))
    $previousUsername = trim(strip_tags($_GET["previousUsername"]));
else
    $previousUsername = NULL;

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
