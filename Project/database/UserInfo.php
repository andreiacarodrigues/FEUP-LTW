<?php
include_once('Connection.php');

global $db;
$username = $_GET["username"];

$stmt = $db->prepare("SELECT name, email, birthdate, postCode, photoId FROM User WHERE username = ?");
$stmt->execute(array($username));
$info = $stmt->fetch();

$stmt = $db->prepare("SELECT * FROM Restaurant WHERE owner = ?");
$stmt->execute(array($username));
$myRest = $stmt->fetchAll();

if(empty($myRest))
    $isOwner = 0;
else
    $isOwner = 1;

$infoArray = array(0 => $info['name'],
    1 => $info['email'],
    2 => $info['birthdate'],
    3 => $info['postCode'],
    4 => $info['photoId'],
    5 => $isOwner);
if(!empty($info))
    echo json_encode($infoArray);
else
    echo 'INVALID';

?>