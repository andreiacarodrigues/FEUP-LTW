<?php
//User Profile Photo

 include_once('my_database/connection.php');

global $db;

if(isset($_GET["val"]) && isset($_GET["id"]))
{
    $val = trim(strip_tags($_GET["val"]));
    $id = trim(strip_tags($_GET["id"]));
}
else
    die(header('Location: ' . $_SERVER["HTTP_REFERER"]));


$stmt = $db->prepare("SELECT photoId from User WHERE username = ?");
$stmt->execute(array($val));
$deleteId = $stmt->fetch();
$deleteId = $deleteId['photoId'];

if($deleteId != null)
{
	$stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
	$stmt->execute(array($deleteId));

	unlink("../css/images/$deleteId.jpg");
	unlink("../css/images_small/$deleteId.jpg");
	unlink("../css/images_medium/$deleteId.jpg");
}
$stmt = $db->prepare("UPDATE User SET photoId = ? WHERE username = ?");
$stmt->execute(array($id, $val));

header('Location: ../userProfileEdit.php?username=' . $val);
exit;
?>