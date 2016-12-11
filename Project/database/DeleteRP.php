<?php
//delete Restaurant Photo

include_once('my_database/Photo.php');

$val = $_POST['val'];
$res = $_POST['restaurant'];

$deleteId = getPhotoByName($val);
$deleteId = $deleteId['photoId'];

deletePhoto($deleteId);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $res);
exit;
?>