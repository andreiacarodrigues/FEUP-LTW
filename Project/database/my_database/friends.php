<?php
include_once('connection.php');

    function addFriend($sessionUsername,$username)
    {
        global $db;
        $stmt = $db->prepare("INSERT INTO Friend VALUES (?, ?)");
        return $stmt->execute(array($sessionUsername, $username));
    }

    function getFriends($sessionUsername)
    {
        global $db;
        $stmt = $db->prepare("SELECT username2 FROM Friend WHERE username1 = ?");
        $stmt->execute(array($sessionUsername));
        return $stmt->fetchAll();
    }

    function deleteFriendship($sessionUsername,$username)
    {
        global $db;
        $stmt = $db->prepare("DELETE FROM Friend WHERE username1 = ? AND username2 = ?");
        return $stmt->execute(array($sessionUsername, $username));
    }

?>
