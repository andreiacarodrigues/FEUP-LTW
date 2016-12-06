<?php
include_once('Connection.php');

global $db;
$username = $_GET["username"];
$stmt = $db->prepare('SELECT name, rating_sum, location, photoId FROM Restaurant WHERE owner = ?');
$stmt->execute(array($username));
$restaurants = $stmt->fetchAll();

$result = array();
foreach ($restaurants as $restaurant)
{
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
