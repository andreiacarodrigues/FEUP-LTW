<?php
//User Profile Photo

include_once('my_database/Photo.php');
include_once('my_database/User.php');

$val = $_GET['val'];
$id = $_GET['id'];

$deleteId = getUserPhoto($val);
$deleteId = $deleteId['photoId'];

if($deleteId != null)
{
    deletePhoto($deleteId);
}

updateUserPhoto($id,$val);

header('Location: ../userProfileEdit.php?username=' . $val);
exit;
?>