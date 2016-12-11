<?php
include_once('Connection.php');

    function getRestaurantId($name)
    {
        global $db;
        $stmt = $db->prepare("SELECT restaurantId FROM Restaurant WHERE name = ?");
        $stmt->execute(array($name));
        return $stmt->fetch();
    }

    function addRestaurant($name,$description,$location,$postCode,$schedule,$avgPrice,$contact,$observation,$owner)
    {
        global $db;
        $stmt = $db->prepare("INSERT INTO Restaurant VALUES (null, ?, ?, ?, ?, ? ,?, ?, ?, null, null, 0, 0, ?)");
        return $stmt->execute(array($name, $description, $location, $postCode,$schedule, $avgPrice, $contact, $observation, $owner));
    }

?>