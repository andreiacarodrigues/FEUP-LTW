<?php
include_once('my_database/restaurant.php');
include_once('my_database/reviews.php');
include_once('my_database/photo.php');

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

$reviews = getReviewsByUser($username);

$result = array();
foreach ($reviews as $review)
{
    $name = getRestaurantName($review['restaurantId']);
    $restaurant = getRestaurantsByName($name['name']);
    $photo = getPhoto($restaurant['photoId']);

    $infoArray = array(0 => $name['name'],
        1 => $restaurant['rating_sum'],
        2 => $restaurant['location'],
        3 => $photo['filename']);

    $result[] = $infoArray;
}

$result = array_map("unserialize", array_unique(array_map("serialize", $result)));

if(!empty($result))
    echo json_encode($result);
else
    echo 'INVALID';
?>