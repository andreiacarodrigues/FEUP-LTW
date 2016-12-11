<?php
//Restaurant Profile Photo 

include_once('my_database/restaurant.php');

$val = $_GET['val'];
$id = $_GET['id'];

$restaurantId = getRestaurantId($val);
$restaurantId = $restaurantId['restaurantId'];

addRestaurantPhoto($id,$restaurantId);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
exit;
?>
