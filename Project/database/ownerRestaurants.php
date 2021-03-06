<?php
include_once('my_database/restaurant.php');
include_once('my_database/photo.php');

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    die('ERROR');

if(!is_username($username))
	die('ERROR');

$restaurants = getRestaurantsByOwner($username);

$result = array();
foreach ($restaurants as $restaurant)
{
    $photo = getPhoto($restaurant['photoId']);

    $infoArray = array(0 => $restaurant['name'],
        1 => $restaurant['rating_sum'],
        2 => $restaurant['location'],
        3 => $photo['filename'],
		4 => $restaurant['rating_total']);
		
    $result[] = $infoArray;
}

if(!empty($result))
    echo json_encode($result);
else
    echo 'INVALID';
?>
