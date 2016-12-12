<?php
//Profile Photo

include_once('my_database/restaurant.php');
include_once('my_database/user.php');
include_once('my_database/photo.php');

if (isset ($_POST["val"] ))
    $val = trim(strip_tags($_POST["val"]));
else
    $val = NULL;

if (isset ($_POST["mode"] ))
    $mode = trim(strip_tags($_POST["mode"]));
else
    $mode = NULL;

if($mode)   //restaurant
    $deleteId = getRestaurantsByName($val);
else    //user
    $deleteId = getUserPhoto($val);

$deleteId = $deleteId['photoId'];

if($deleteId != null)   //falta condicao para ver se nao esta a eliminar as fotos default
{
    if($mode)
        updateRestaurantPPhoto(NULL,$val);
    else
        updateUserPhoto(NULL,$val);
    deletePhoto($deleteId);
}

if($mode)
    header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
else
    header('Location: ../userProfileEdit.php?user=' . $val);

exit;
?>
