<?php
include_once('Connection.php');

global $db;
$username = $_GET["username"];

$stmt = $db->prepare('SELECT reviewId, restaurantId, rating, text, date FROM Review WHERE username = ?');
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
    $photosId = $stmt->fetchAll();

    $photos = array();
    foreach ($photosId as $photoId)
    {
        $stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
        $stmt->execute(array($photoId['photoId']));
        $photo = $stmt->fetch();
        $photos[] = $photo['filename'];
    }

    $stmt = $db->prepare('SELECT username, text FROM ReviewReply WHERE reviewId = ? ');
    $stmt->execute(array($review['reviewId']));
    $repliesRes = $stmt->fetchAll();

    $replies = array();
    foreach ($repliesRes as $reply)
    {
        $replies[] = array($reply['username'], $reply['text']);
    }

    $infoArray = array(0 => $review['reviewId'],
        1 => $name['name'],
        2 => $review['rating'],
        3 => $review['text'],
        4 => $photos,
        5 => $review['date'],
        6 => $replies);

    $result[] = $infoArray;
}

if(!empty($result))
    echo json_encode($result);
else
    echo 'INVALID';
?>
