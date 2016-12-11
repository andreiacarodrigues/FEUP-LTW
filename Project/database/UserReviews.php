<?php
include_once('my_database/User.php');
include_once('my_database/Restaurant.php');
include_once('my_database/Reviews.php');
include_once('my_database/Photo.php');

$username = $_GET["username"];

$reviews = getReviewsByUser($username);

$result = array();
foreach ($reviews as $review)
{
    $name = getRestaurantName($review['restaurantId']);
    $photosId = getReviewPhoto($review['reviewId']);

    $photos = array();
    foreach ($photosId as $photoId)
    {
        $photo = getPhoto($photoId['photoId']);
        $photos[] = $photo['filename'];
    }

    $repliesRes = getReviewReply($review['reviewId']);

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
