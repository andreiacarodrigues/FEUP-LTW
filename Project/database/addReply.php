<?php
include_once('my_database/reviews.php');

if (isset ($_GET["id"] ))
    $id = trim(strip_tags($_GET["id"]));
else
    $id = NULL;

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

if (isset ($_GET["text"] ))
    $text = trim(strip_tags($_GET["text"]));
else
    $text = NULL;

addReviewReply($id, $username, $text);

$info = getAllReviewReply();

echo json_encode($info);

?>
