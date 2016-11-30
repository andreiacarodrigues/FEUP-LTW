<?php
include_once('database/User.php');
include_once('./configurations.php');

function login($username, $password) {

    $user = userExists($username, $password);

    //se nao existir diz que nao existe

    //verifica a password

    $_SESSION ["userid"] = $user ["id"];
}

function isUserLoggedIn() {
    return isset ( $_SESSION ["userid"] );
}

?>