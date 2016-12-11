<?php
include_once('Connection.php');

    function addFriend($sessionUsername,$username)
    {
        global $db;
        $stmt = $db->prepare("INSERT INTO Friend VALUES (?, ?)");
        return $stmt->execute(array($sessionUsername, $username));
    }

?>