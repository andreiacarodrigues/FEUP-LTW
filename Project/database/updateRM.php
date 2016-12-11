<?php
//Restaurant Menu
include_once('my_database/restaurant.php');
include_once('my_database/photo.php');

$val = $_GET['val'];
$id = $_GET['id'];

$deleteId = getRestaurantMenu($val);

$deleteId = $deleteId['menuId'];

if($deleteId != 1)
{
    deletePhoto($deleteId);
}

updateRestaurantMenu($id,$val);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
exit;
?>
