<?php
//Profile Photo

include_once('my_database/restaurant.php');
include_once('my_database/user.php');
include_once('my_database/photo.php');

if (isset ($_POST["val"] ))
    $val = trim(strip_tags($_POST["val"]));
else
    $val = NULL;

if (isset ($_POST["method"] ))
    $mode = trim(strip_tags($_POST["method"]));
else
    $mode = NULL;

if ($_SESSION['csrf_token'] !== $_POST['csrf_token'])
    die(header('Location: ' . $_SERVER["HTTP_REFERER"]));

if($mode == 2)   //restaurant
    $deleteId = getRestaurantsByName($val);
else  if($mode == 1)  //user
    $deleteId = getUserPhoto($val);

$deleteId = $deleteId['photoId'];

if($deleteId != null)   //falta condicao para ver se nao esta a eliminar as fotos default
{
    if($mode == 2)
        updateRestaurantPPhoto(NULL,$val);
    else if($mode == 1)
        updateUserPhoto(NULL,$val);
    deletePhoto($deleteId);
}

if($mode == 2)
    header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
else if($mode == 1)
    header('Location: ../userProfileEdit.php?user=' . $val);

exit;
?>
