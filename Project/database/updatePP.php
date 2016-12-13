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

if (isset ($_GET["method"] ))
    $mode = trim(strip_tags($_GET["method"]));
else
    $mode = NULL;

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
