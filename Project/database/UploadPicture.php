<?php

include_once('Connection.php');
global $db;

$method = $_POST['method'];
$val = $_POST['val'];

$stmt = $db->prepare("INSERT INTO Photo VALUES(NULL,?)");
$stmt->execute(array(""));
$id = $db->lastInsertId();

$stmt = $db->prepare("UPDATE Photo SET filename = ? WHERE photoId = ?");
$stmt->execute(array("$id.jpg", $id));

$originalFileName = "../css/images/$id.jpg";
$smallFileName = "../css/images_small/$id.jpg";
$mediumFileName = "../css/images_medium/$id.jpg";

move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

$original = imagecreatefromjpeg($originalFileName);

$width = imagesx($original);
$height = imagesy($original);
$square = min($width, $height);

// Create small square thumbnail
$small = imagecreatetruecolor(200, 200);
imagecopyresized($small, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 200, 200, $square, $square);
imagejpeg($small, $smallFileName);

$mediumwidth = $width;
$mediumheight = $height;

if ($mediumwidth > 400) {
    $mediumwidth = 400;
    $mediumheight = $mediumheight * ( $mediumwidth / $width );
}

$medium = imagecreatetruecolor($mediumwidth, $mediumheight);
imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
imagejpeg($medium, $mediumFileName);

if($method == 1)
{
    header('Location: UpdateUPP.php?val=' . $val . "&id=" . $id);
    exit;
}
if($method == 2)
{
    header('Location: UpdateRPP.php?val=' . $val . "&id=" . $id);
    exit;
}
if($method == 5)
{
    header('Location: UpdateRM.php?val=' . $val . "&id=" . $id);
}
//header('Location: ' . $_SERVER["HTTP_REFERER"] );
//exit;
?>
