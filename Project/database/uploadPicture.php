<?php
include_once('my_database/photo.php');
global $db;

$method = $_POST['method'];
$val = $_POST['val'];

if($val == "NULL")
    die(header('Location: ' . $_SERVER["HTTP_REFERER"]));
else
{
    $id = addPhoto();

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

    if($method == 1 || $method == 2)
        header('Location: UpdatePP.php?val=' . $val . "&id=" . $id . "&mode=" . $method);
    else if($method == 4)
        header('Location: UpdateRP.php?val=' . $val . "&id=" . $id);
    else if($method == 5)
        header('Location: UpdateRM.php?val=' . $val . "&id=" . $id);
}
//header('Location: ' . $_SERVER["HTTP_REFERER"] );
//exit;
?>
