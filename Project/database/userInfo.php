﻿<?php
include_once('my_database/user.php');
include_once('my_database/restaurant.php');

if (isset($_GET["username"]))
    $username = trim(strip_tags($_GET["username"]));
else
    die('ERROR');

if(!is_username($username))
	die('ERROR');

$info = getUserInfo($username);

if(empty($info))
    die("USER ERROR");

$myRest = getRestaurantsByOwner($username);

if(empty($myRest))
    $isOwner = 0;
else
    $isOwner = 1;

$infoArray = array(0 => $info['name'],
    1 => $info['email'],
    2 => $info['birthdate'],
    3 => $info['postCode'],
    4 => $info['photoId'],
    5 => $isOwner,
	6 => $info['location']);

if(!empty($info))
    echo json_encode($infoArray);
else
    echo 'INVALID';

?>
