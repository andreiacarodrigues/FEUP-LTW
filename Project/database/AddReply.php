<?php
include_once('my_database/Reviews.php');

global $db;

$id = $_GET["id"];
$username = $_GET["username"];
$text = $_GET["text"];

addReviewReply($id, $username, $text);

$info = getReviewReply();

echo json_encode($info);
?>