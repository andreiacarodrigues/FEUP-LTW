<?php
include_once('my_database/restaurant.php');

if (isset($_GET["owner"]) && isset($_GET["name"]) && isset($_GET["description"]) && isset($_GET["location"]) && isset($_GET["postCode"]) && isset($_GET["schedule"]) && isset($_GET["avgPrice"]) && isset($_GET["contact"]) && isset($_GET["observation"]))
{
    $owner = trim(strip_tags($_GET["owner"]));
    $name = trim(strip_tags($_GET["name"]));
    $description = trim(strip_tags($_GET["description"]));
    $location = trim(strip_tags($_GET["location"]));
    $schedule = trim(strip_tags($_GET["schedule"]));
    $postCode = trim(strip_tags($_GET["postCode"]));
    $avgPrice = trim(strip_tags($_GET["avgPrice"]));
    $contact = trim(strip_tags($_GET["contact"]));
    $observation = trim(strip_tags($_GET["observation"]));
}
else
{
    die(header('Location: ' . $_SERVER["HTTP_REFERER"] ));
}

$info = getRestaurantId($name);

if(empty($info))
    addRestaurant($name,$description,$location,$postCode,$schedule,$avgPrice,$contact,$observation,$owner); //tinha echo
else
    echo 'INVALID';
?>
