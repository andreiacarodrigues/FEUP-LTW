<?php
//Profile Photo

include_once('my_database/restaurant.php');
include_once('my_database/user.php');
include_once('my_database/photo.php');

if (isset ($_POST["val"] ) && isset ($_POST["method"] ))
{
    $val = trim(strip_tags($_POST["val"]));
    $mode = trim(strip_tags($_POST["method"]));

    if(!(($mode == 1) || ($mode == 2)))
        die('ERROR receiving parameters');
	//if(!(is_username($val)))
	//	die('ERROR 1');
}
else
{
    die('ERROR');
}

if($mode == 2){
    $deleteId = getRestaurantPPhoto($val);
}   //restaurant
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
