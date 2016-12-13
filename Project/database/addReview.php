<?php
include_once('my_database/restaurant.php');
include_once('my_database/reviews.php');
include_once('my_database/photo.php');

if (isset ($_POST["restaurant"] ))
    $restaurant = trim(strip_tags($_POST["restaurant"]));
else
    $restaurant = NULL;

if (isset ($_POST["username"] ))
    $username = trim(strip_tags($_POST["username"]));
else
    $username = NULL;

if (isset ($_POST["text"] ))
    $text = trim(strip_tags($_POST["text"]));
else
    $text = NULL;

if (isset ($_POST["rating"] ))
    $rating = trim(strip_tags($_POST["rating"]));
else
    $rating = NULL;

if (isset ($_POST["date"] ))
    $date = trim(strip_tags($_POST["date"]));
else
    $date = NULL;

if($rating == -1)
    die(header('Location: ../restaurantProfile.php?restaurant=' . $restaurant . '&errorReview="1"#newReview'));
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
