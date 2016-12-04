<?php
include_once('database/User.php');
include_once('./configurations.php');

function isUserLoggedIn() {
    return isset($_SESSION ["userid"]);
}
?>

