<?php
//User Profile Photo

include_once('Connection.php');

global $db;

$val = $_GET['val'];
$id = $_GET['id'];

$stmt = $db->prepare("SELECT photoId from User WHERE username = ?");
$stmt->execute(array($val));
$deleteId = $stmt->fetch();
$deleteId = $deleteId['photoId'];

$stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
$stmt->execute(array($deleteId));

unlink("../css/images/$deleteId.jpg");
unlink("../css/images_small/$deleteId.jpg");
unlink("../css/images_medium/$deleteId.jpg");

$stmt = $db->prepare("UPDATE User SET photoId = ? WHERE username = ?");
$stmt->execute(array($id, $val));

header('Location: ../userProfileEdit.php?username=' . $val);
exit;
?>