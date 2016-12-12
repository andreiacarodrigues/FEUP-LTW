<?php
include_once('my_database/photo.php');

if (isset ($_GET["id"] ))
    $id = trim(strip_tags($_GET["id"]));
else
    $id = NULL;

$info = getPhoto($id);

if(!empty($info))
    echo json_encode($info['filename']);
else
    echo 'INVALID';
?>
