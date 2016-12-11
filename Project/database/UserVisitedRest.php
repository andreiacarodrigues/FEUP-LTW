<?php
include_once('my_database/Restaurant.php');
include_once('my_database/Reviews.php');
include_once('my_database/Photo.php');

global $db;
$username = $_GET["username"];

$restaurants = getReviewsByUser($username);

$result = array();
foreach ($restaurants as $restaurantId)
{
    $name = getRestaurantName($restaurantId['restaurantId']);
    $restaurant = getRestaurantsByName($name['name']);
    $photo = getPhoto($restaurant['photoId']);

    $infoArray = array(0 => $restaurant['name'],
        1 => $restaurant['rating_sum'],
        2 => $restaurant['location'],
        3 => $photo['filename']);

    $result[] = $infoArray;
}

if(!empty($result))
    echo json_encode($result);
else
    echo 'INVALID';
?>
