<?php
include_once('my_database/restaurant.php');
include_once('my_database/reviews.php');
include_once('my_database/photo.php');

if (isset ($_GET["restaurant"] ))
    $restaurant = trim(strip_tags($_GET["restaurant"]));
else
    die('ERROR');

$restaurantId = getRestaurantId($restaurant);

$reviews = getReviewsByRestaurant($restaurantId['restaurantId']);

$result = array();
foreach ($reviews as $review)
{
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
    $infoArray = array(
        0 => $review['reviewId'],
        1 => $review['username'],
        2 => $review['rating'],
        3 => $review['text'],
        4 => $photos,
        5 => $review['date'],
        6 => $replies);

    $result[] = $infoArray;
}

if(!empty($reviews))
    echo json_encode($result);
else
    echo 'INVALID';

?>
