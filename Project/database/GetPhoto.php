<?php
include_once('my_database/Photo.php');

$id = $_GET["id"];

$info = getPhoto($id);

if(!empty($info))
    echo json_encode($info['filename']);
else
    echo 'INVALID';
?>