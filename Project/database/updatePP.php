<?php
// Profile Photo

include_once('my_database/photo.php');
include_once('my_database/user.php');
include_once('my_database/restaurant.php');

if (isset ($_GET["val"] ) && isset ($_GET["id"] ) && isset ($_GET["method"] ))
{
    $val = trim(strip_tags($_GET["val"]));
    $id = trim(strip_tags($_GET["id"]));
    $mode = trim(strip_tags($_GET["method"]));
	
	if(!((($mode ==1)&&is_username($val)) || ($mode == 2)))
		die('ERROR');
}
else
    die('ERROR');


if(($val != NULL) && ($id != NULL) && ($mode != NULL))
{
	if(($val == "") && ($id != NULL) && ($mode != NULL))
	{
		if($mode == 1)
		{
			updateUserPhoto($id,$val);
			header('Location: ../userProfileEdit.php?username=' . $val);
		}
		else if($mode == 2)
		{
			updateRestaurantPPhoto($id,$val);
			header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
		}
		exit;
	}
else{
	
	if($mode == 1)   //user
		$deleteId = getUserPhoto($val);
	else if($mode == 2)    //restaurant
		$deleteId = getRestaurantPPhoto($val);

	$deleteId = $deleteId['photoId'];
	if($deleteId != null)   //mudar isto para não eliminar as fotos default
		deletePhoto($deleteId);

	if($mode == 1)
	{
		updateUserPhoto($id,$val);
		header('Location: ../userProfileEdit.php?username=' . $val);
	}
	else if($mode == 2)
	{
		updateRestaurantPPhoto($id,$val);
		header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
	}
	exit;
}
}else
	die(header('Location: ../index.php'));

?>
