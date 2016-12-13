<?php
//delete review reply

include_once('my_database/reviews.php');

if ((isset ($_GET["id"] )) && (isset ($_GET["username"] )) && (isset ($_GET["text"] )))
{
	$id = trim(strip_tags($_GET["id"]));
	$username = trim(strip_tags($_GET["username"]));
	$text = trim(strip_tags($_GET["text"]));
	deleteReviewReply($id, $username, $text);

	echo "DONE";
	exit;
}

?>
