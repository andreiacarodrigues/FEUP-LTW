<?php
include_once('my_database/restaurant.php');

if (isset ($_GET["restaurant"] ))
    $restaurant = trim(strip_tags($_GET["restaurant"]));
else
    die('ERROR');

$info = getRestaurantsByName($restaurant);

if(!empty($info))
{
    $infoArray = array(0 => $info['restaurantId'],
        1 => $info['description'],
        2 => $info['location'],
        3 => $info['contact'],
        4 => $info['avgPrice'],
        5 => $info['schedule'],
        6 => $info['observation'],
        7 => $info['menuId'],
        8 => $info['photoId'],
        9 => $info['rating_sum'],
        10 => $info['rating_total'],
        11 => $info['owner'],
        12 => $info['postCode']
    );

    echo json_encode($infoArray);
}
else
    echo 'INVALID';

?>
