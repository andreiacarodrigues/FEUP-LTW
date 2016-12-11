<?php
//User Profile Photo

include_once('my_database/user.php');
include_once('my_database/photo.php');

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
