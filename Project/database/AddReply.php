﻿<?php
include_once('my_database/Reviews.php');

$id = $_GET["id"];
$username = $_GET["username"];
$text = $_GET["text"];

addReviewReply($id, $username, $text);

$info = getAllReviewReply();

echo json_encode($info);
?>