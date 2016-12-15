<?php
//delete Restaurant Photo
include_once('my_database/photo.php');
if (isset ($_POST["val"] ) && isset ($_POST["restaurant"] ))
{
    $val = trim(strip_tags($_POST["val"]));
    $res = trim(strip_tags($_POST["restaurant"]));
}
else
{
    die('ERROR');
}
$deleteId = getPhotoByFilename($val);
$deleteId = $deleteId['photoId'];
deletePhoto($deleteId);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $res);
?>