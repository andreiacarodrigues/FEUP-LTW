<?php
//User Profile Photo

include_once('my_database/User.php');
include_once('my_database/Photo.php');

$val = $_POST['val'];

$deleteId = getUserPhoto($val);
$deleteId = $deleteId['photoId'];

if($deleteId != null)
{
    updateUserPhoto(NULL,$val);

    deletePhoto($deleteId);
}

header('Location: ../userProfileEdit.php?user=' . $val);
exit;
?>