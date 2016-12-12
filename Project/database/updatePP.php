<?php
// Profile Photo

include_once('my_database/photo.php');
include_once('my_database/user.php');
include_once('my_database/restaurant.php');

if (isset ($_GET["val"] ))
    $val = trim(strip_tags($_GET["val"]));
else
    $val = NULL;

if (isset ($_GET["id"] ))
    $id = trim(strip_tags($_GET["id"]));
else
    $id = NULL;

if (isset ($_GET["mode"] ))
    $mode = trim(strip_tags($_GET["mode"]));
else
    $mode = NULL;

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
