<?php
include_once('my_database/restaurant.php');

// Restaurant Info
if (isset ($_GET["id"] ))
    $id = trim(strip_tags($_GET["id"]));
else
    $id = NULL;

if (isset ($_GET["name"] ))
    $name = trim(strip_tags($_GET["name"]));
else
    $name = NULL;

if (isset ($_GET["description"] ))
    $description = trim(strip_tags($_GET["description"]));
else
    $description = NULL;

if (isset ($_GET["location"] ))
    $location = trim(strip_tags($_GET["location"]));
else
    $location = NULL;

if (isset ($_GET["postCode"] ))
    $postCode = trim(strip_tags($_GET["postCode"]));
else
    $postCode = NULL;

if (isset ($_GET["contact"] ))
    $contact = trim(strip_tags($_GET["contact"]));
else
    $contact = NULL;

if (isset ($_GET["avgPrice"] ))
    $avgPrice = trim(strip_tags($_GET["avgPrice"]));
else
    $avgPrice = NULL;

if (isset ($_GET["schedule"] ))
    $schedule = trim(strip_tags($_GET["schedule"]));
else
    $schedule = NULL;

if (isset ($_GET["observation"] ))
    $observation = trim(strip_tags($_GET["observation"]));
else
    $observation = NULL;

updateRestaurant($name, $description, $location, $contact, $avgPrice, $schedule, $observation, $postCode, $id);
?>
