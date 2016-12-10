<?php
//User Profile Photo

include_once('Connection.php');

global $db;

$val = $_POST['val'];

$stmt = $db->prepare("SELECT photoId from User WHERE username = ?");
$stmt->execute(array($val));
$deleteId = $stmt->fetch();
$deleteId = $deleteId['photoId'];

$stmt = $db->prepare("UPDATE User SET photoId = NULL WHERE username = ?");
$stmt->execute(array($val));

$stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
$stmt->execute(array($deleteId));

unlink("../css/images/$deleteId.jpg");
unlink("../css/images_small/$deleteId.jpg");
unlink("../css/images_medium/$deleteId.jpg");

header('Location: ../restaurantProfileEdit.php?restaurant=' . $val);
exit;
?>