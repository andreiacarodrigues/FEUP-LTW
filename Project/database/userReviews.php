<?php
include_once('my_database/user.php');
include_once('my_database/restaurant.php');
include_once('my_database/reviews.php');
include_once('my_database/photo.php');

if (isset ($_GET["username"] ))
{
    $username = trim(strip_tags($_GET["username"]));

	$reviews = getReviewsByUser($username);

	$result = array();
	foreach ($reviews as $review)
	{
		$name = getRestaurantName($review['restaurantId']);
		$photosId = getReviewPhoto($review['reviewId']);

		$photos = array();
		foreach ($photosId as $photoId)
		{
			$photo = getPhoto($photoId['photoId']);
			$photos[] = $photo['filename'];
		}

		$repliesRes = getReviewReply($review['reviewId']);

		$replies = array();
		foreach ($repliesRes as $reply)
		{
			$replies[] = array($reply['username'], $reply['text']);
		}

		$infoArray = array(0 => $review['reviewId'],
			1 => $name['name'],
			2 => $review['rating'],
			3 => $review['text'],
			4 => $photos,
			5 => $review['date'],
			6 => $replies);

		$result[] = $infoArray;
	}

	if(!empty($result))
		echo json_encode($result);
	else
		echo 'INVALID';
}
else
    die('ERROR');
?>
