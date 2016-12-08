<?php
include_once('Connection.php');

global $db;
$username = $_GET["username"];
$stmt = $db->prepare('SELECT reviewId, restaurantId, rating, text FROM Review WHERE username = ?');
$stmt->execute(array($username));
$reviews = $stmt->fetchAll();

$result = array();
foreach ($reviews as $review)
{
    $stmt = $db->prepare('SELECT name FROM Restaurant WHERE restaurantId = ?');
    $stmt->execute(array($review['restaurantId']));
    $name = $stmt->fetch();

    $stmt = $db->prepare('SELECT photoId FROM ReviewPhoto WHERE restaurantId = ? AND username = ?');
    $stmt->execute(array($review['restaurantId'],$username));
    $photosId = $stmt->fetch();

    $photos = array();
    foreach ($photosId as $photoId)
    {
        $stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
        $stmt->execute(array($photoId));
        $photos[] = $stmt->fetch();
    }

    $infoArray = array(0 => $review['reviewId'],
        1 => $name,
        2 => $review['rating'],
        3 => $review['text'],
        4 => $photosId);

    $result[] = $infoArray;
}

if(!empty($reviews))
    echo json_encode($result);
else
    echo 'INVALID';

?>
