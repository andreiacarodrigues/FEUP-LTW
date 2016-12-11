<?php
include_once('my_database/Restaurant.php');
include_once('my_database/Photo.php');

$restaurant = $_GET["restaurant"];

$restaurantId = getRestaurantId($restaurant);

$photos = getRestaurantPhotos($restaurantId['restaurantId']);

$result = array();
foreach ($photos as $photo)
{
    $myphoto = getPhoto($photo['photoId']);
    $result[] = $myphoto['filename'];
}

if(!empty($result))
    echo json_encode($result);
else
    echo 'INVALID';
?>