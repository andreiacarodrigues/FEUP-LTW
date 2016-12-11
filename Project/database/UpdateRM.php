<?php
//Restaurant Menu
include_once('my_database/Connection.php');
include_once('my_database/Restaurant.php');

global $db;

$val = $_GET['val'];
$id = $_GET['id'];

$deleteId = getRestaurantMenu($val);

$deleteId = $deleteId['menuId'];

if($deleteId != 1)
{
    $stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
    $stmt->execute(array($deleteId));

    unlink("../css/images/$deleteId.jpg");
    unlink("../css/images_small/$deleteId.jpg");
    unlink("../css/images_medium/$deleteId.jpg");
}

updateRestaurantMenu($id,$val);

header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
exit;
?>