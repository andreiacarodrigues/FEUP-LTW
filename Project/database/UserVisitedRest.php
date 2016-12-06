<?php
include_once('Connection.php');

global $db;
$username = $_GET["username"];
$stmt = $db->prepare('SELECT restaurantId FROM Review WHERE username = ?');
$stmt->execute(array($username));
$restaurants = $stmt->fetch();

$result = array();
foreach ($restaurants as $restaurantId)
{
    $stmt = $db->prepare('SELECT name , location, rating_sum, photoId FROM Restaurant WHERE restaurantId = ?');
    $stmt->execute(array($restaurantId));
    $restaurant = $stmt->fetch();

    $stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
    $stmt->execute(array($restaurant['photoId']));
    $photo = $stmt->fetch();

    $infoArray = array(0 => $restaurant['name'],
        1 => $restaurant['rating_sum'],
        2 => $restaurant['location'],
        3 => $photo['filename']);
    $result[] = $infoArray;
}

echo json_encode($result);
?>
