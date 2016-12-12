<?php
//Restaurant Menu
include_once('my_database/restaurant.php');
include_once('my_database/photo.php');

if (isset ($_GET["val"] ))
    $val = trim(strip_tags($_GET["val"]));
else
    $val = NULL;

if (isset ($_GET["id"] ))
    $id = trim(strip_tags($_GET["id"]));
else
    $id = NULL;


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
