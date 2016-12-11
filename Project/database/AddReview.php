<?php
include_once('my_database/Restaurant.php');
include_once('my_database/Reviews.php');
include_once('my_database/Connection.php');

global $db;

$restaurant = $_POST["restaurant"];
$username = $_POST["username"];
$text = $_POST["text"];
$rating = $_POST["rating"];
$date = $_POST["date"];

if($rating == -1)
    die(header('Location: ../restaurantProfile.php?restaurant=' . $restaurant . '&errorReview="1"#newReview'));
else
{
    // Restaurant ID
    $restaurantId = getRestaurantId($restaurant);

    // Review
    addReview($username,$restaurantId['restaurantId'],$rating,$text,$date);

    $reviewId = getFirstReviewId();

    $photo = null;
    if ($_FILES['image']['tmp_name']){
        // Photo

        $stmt = $db->prepare("INSERT INTO Photo VALUES(NULL,?)");
        $stmt->execute(array(""));
        $photo = $db->lastInsertId();

        $stmt = $db->prepare("UPDATE Photo SET filename = ? WHERE photoId = ?");
        $stmt->execute(array("$photo.jpg", $photo));

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
        $stmt = $db->prepare("INSERT INTO ReviewPhoto VALUES (?, ?)");
        $stmt->execute(array($reviewId['reviewId'], $photo));

    }
}

header('Location: ../restaurantProfile.php?restaurant=' . $restaurant);
exit;
?>