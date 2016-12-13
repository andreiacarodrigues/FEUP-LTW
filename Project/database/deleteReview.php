<?php
//delete review

include_once('my_database/reviews.php');

if (isset ($_GET["id"] ))
{
	$id = trim(strip_tags($_GET["id"]));
	deleteReview($id);

	echo "DONE";
	exit;
}
else
	die('ERROR');

?>
