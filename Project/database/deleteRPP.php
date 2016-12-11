<?php
//Restaurant Profile Photo 

include_once('my_database/restaurant.php');
include_once('my_database/photo.php');

$val = $_POST['val'];

$deleteId = getRestaurantsByName($val);
$deleteId = $deleteId['photoId'];

updateRestaurantPPhoto(NULL,$val);

if($deleteId != 1)
{
    deletePhoto($deleteId);
}
header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
exit;
?>
