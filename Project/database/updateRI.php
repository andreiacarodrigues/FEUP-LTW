<?php
include_once('my_database/restaurant.php');

// Restaurant Info
if (isset($_GET["id"]) && isset($_GET["name"]) && isset($_GET["description"]) && isset($_GET["location"]) && isset($_GET["postCode"]) && isset($_GET["contact"]) && isset($_GET["avgPrice"]) && isset($_GET["schedule"]) && isset($_GET["observation"]))
{
    $id = trim(strip_tags($_GET["id"]));
    $name = trim(strip_tags($_GET["name"]));
    $description = trim(strip_tags($_GET["description"]));
    $location = trim(strip_tags($_GET["location"]));
    $postCode = trim(strip_tags($_GET["postCode"]));
    $contact = trim(strip_tags($_GET["contact"]));
    $avgPrice = trim(strip_tags($_GET["avgPrice"]));
    $schedule = trim(strip_tags($_GET["schedule"]));
    $observation = trim(strip_tags($_GET["observation"]));

}
else
    die(header('Location: ' . $_SERVER["HTTP_REFERER"]));

updateRestaurant($name, $description, $location, $contact, $avgPrice, $schedule, $observation, $postCode, $id);
?>
