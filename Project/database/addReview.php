<?php
include_once('my_database/restaurant.php');
include_once('my_database/reviews.php');
include_once('my_database/photo.php');

if (isset($_POST["restaurant"]) && isset($_POST["username"]) && isset($_POST["text"]) && isset($_POST["rating"]) && isset($_POST["date"]))
{
    $restaurant = trim(strip_tags($_POST["restaurant"]));
    $username = trim(strip_tags($_POST["username"]));
    $text = trim(strip_tags($_POST["text"]));
    $rating = trim(strip_tags($_POST["rating"]));
    $date = trim(strip_tags($_POST["date"]));
	
	if(!(is_text($restaurant) && is_username($username) && is_text($date)))
		die('ERROR');
	if($text != "")
		if(!is_text($text))
			die('ERROR');
}
else
{
    die('ERROR');
}

if($rating == -1)
    die(header('Location: ../restaurantProfile.php?restaurant=' . $restaurant ));
else
{
    // Restaurant ID
    $restaurantId = getRestaurantId($restaurant);

    // Review
    $oi = addReview($username,$restaurantId['restaurantId'],$rating,$text,$date);
	
    $reviewId = getFirstReviewId();

    $photo = null;
    if ($_FILES['image']['tmp_name']){
        // Photo
        $photo = addPhoto();

        $originalFileName = "../css/images/$photo.jpg";
        $smallFileName = "../css/images_small/$photo.jpg";
        $mediumFileName = "../css/images_medium/$photo.jpg";

        move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

        $original = imagecreatefromjpeg($originalFileName);

        $width = imagesx($original);
        $height = imagesy($original);
        $square = min($width, $height);

        // Create small square thumbnail
        $small = imagecreatetruecolor(200, 200);
        imagecopyresized($small, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 200, 200, $square, $square);
        imagejpeg($small, $smallFileName);

        $mediumwidth = $width;
        $mediumheight = $height;

        if ($mediumwidth > 400) {
            $mediumwidth = 400;
            $mediumheight = $mediumheight * ( $mediumwidth / $width );
        }

        $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
        imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
        imagejpeg($medium, $mediumFileName);

        // Review Photo
        addReviewPhoto($reviewId['reviewId'], $photo);
    }
}

header('Location: ../restaurantProfile.php?restaurant=' . $restaurant);
exit;
?>
