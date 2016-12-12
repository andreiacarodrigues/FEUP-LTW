<?php
//Restaurant Profile Photo 

include_once('my_database/restaurant.php');

if (isset ($_GET["val"] ))
    $val = trim(strip_tags($_GET["val"]));
else
    $val = NULL;

if (isset ($_GET["id"] ))
    $id = trim(strip_tags($_GET["id"]));
else
    $id = NULL;

$restaurantId = getRestaurantId($val);
$restaurantId = $restaurantId['restaurantId'];

addRestaurantPhoto($id,$restaurantId);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
exit;
?>
