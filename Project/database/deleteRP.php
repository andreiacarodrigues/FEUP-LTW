<?php
//delete Restaurant Photo

include_once('my_database/photo.php');

if (isset ($_POST["val"] ) && isset ($_POST["restaurant"] ))
{
    $val = trim(strip_tags($_POST["val"]));
    $res = trim(strip_tags($_POST["restaurant"]));
}
else
{
    die('ERROR');
}


$deleteId = $deleteId['photoId'];

deletePhoto($deleteId);


header('Location: ../restaurantProfileEdit.php?restaurant=' . $res);
exit;
?>


<?php
//Restaurant Photo 

include_once('Connection.php');

	global $db;

    $val = $_POST['val'];
	$res = $_POST['restaurant'];
	
	$stmt = $db->prepare("SELECT photoId from Photo WHERE filename = ?");
	$stmt->execute(array($val));
	$deleteId = $stmt->fetch();
	$deleteId = $deleteId['photoId'];
	
	$stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
	$stmt->execute(array($deleteId));
		
	unlink("../css/images/$deleteId.jpg");
	unlink("../css/images_small/$deleteId.jpg");
	unlink("../css/images_medium/$deleteId.jpg");
	
	header('Location: ../restaurantProfileEdit.php?restaurant=' . $res);
	exit;
?>