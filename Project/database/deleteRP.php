<?php
//delete Restaurant Photo

include_once('my_database/photo.php');

if (isset ($_POST["val"] ))
    $val = trim(strip_tags($_POST["val"]));
else
    $val = NULL;

if (isset ($_POST["restaurant"] ))
    $res = trim(strip_tags($_POST["restaurant"]));
else
    $res = NULL;

if ($_SESSION['csrf_token'] !== $_POST['csrf_token'])
    die(header('Location: ' . $_SERVER["HTTP_REFERER"]));

$deleteId = getPhotoByFilename($val);
$deleteId = $deleteId['photoId'];

deletePhoto($deleteId);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $res);
exit;
?>
