<?php
//delete Restaurant Photo

include_once('my_database/photo.php');

$val = $_POST['val'];
$res = $_POST['restaurant'];

$deleteId = getPhotoByFilename($val);
$deleteId = $deleteId['photoId'];

deletePhoto($deleteId);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $res);
exit;
?>
