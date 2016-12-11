<?php
//Restaurant Profile Photo 

include_once('my_database/Restaurant.php');
include_once('my_database/Photo.php');

$val = $_GET['val'];
$id = $_GET['id'];

$deleteId = getRestaurantPPhoto($val);
$deleteId = $deleteId['photoId'];

if($deleteId != 1)
{
    deletePhoto($deleteId);
}

updateRestaurantPPhoto($id,$val);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
exit;
?>