<?php
include_once('Connection.php');

global $db;
$restaurant = $_GET["restaurant"];

$stmt = $db->prepare('SELECT restaurantId FROM Restaurant WHERE name = ?');
$stmt->execute(array($restaurant));
$restaurantId = $stmt->fetch();

$stmt = $db->prepare('SELECT reviewId, username, rating, text, date FROM Review WHERE restaurantId = ?');
$stmt->execute(array($restaurantId['restaurantId']));
$reviews = $stmt->fetchAll();

$result = array();
foreach ($reviews as $review)
{
    $stmt = $db->prepare('SELECT photoId FROM ReviewPhoto WHERE restaurantId = ? AND username = ?');
    $stmt->execute(array($restaurantId['restaurantId'], $review['username']));
    $photosId = $stmt->fetchAll();

    $photos = array();
    foreach ($photosId as $photoId)
    {
        $stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
        $stmt->execute(array($photoId['photoId']));
        $photo = $stmt->fetch();
		$photos[] = $photo['filename'];
    }

    $infoArray = array(
		0 => $review['reviewId'],
		1 => $review['username'],
        2 => $review['rating'],
        3 => $review['text'],
        4 => $photos,
		5 => $review['date']);

    $result[] = $infoArray;
}

if(!empty($reviews))
    echo json_encode($result);
else
    echo 'INVALID';

?>
