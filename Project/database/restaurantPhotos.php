<?php
include_once('my_database/restaurant.php');
include_once('my_database/photo.php');

if (isset ($_GET["restaurant"] ))
    $restaurant = trim(strip_tags($_GET["restaurant"]));
else
    $restaurant = NULL;

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
