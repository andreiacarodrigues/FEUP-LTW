<?php
// Profile Photo

include_once('my_database/photo.php');
include_once('my_database/user.php');
include_once('my_database/restaurant.php');

$val = $_GET['val'];
$id = $_GET['id'];
$mode = $_GET['mode'];

if($mode)   //user
    $deleteId = getUserPhoto($val);
else    //restaurant
    $deleteId = getRestaurantPPhoto($val);

$deleteId = $deleteId['photoId'];
if($deleteId != null)   //mudar isto para não eliminar as fotos default
    deletePhoto($deleteId);

if($mode)
{
    updateUserPhoto($id,$val);
    header('Location: ../userProfileEdit.php?username=' . $val);
}
else
{
    updateRestaurantPPhoto($id,$val);
    header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
}
exit;
?>
