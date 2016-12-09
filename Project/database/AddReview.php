<?php
include_once('Connection.php');

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
		}
		
		// Restaurant ID
		$stmt = $db->prepare("SELECT restaurantId FROM Restaurant WHERE name = ?");
		$stmt->execute(array($restaurant));
		$restaurantId = $stmt->fetch()['restaurantId'];
		
		// Review Photo
		$stmt = $db->prepare("INSERT INTO ReviewPhoto VALUES (?, ?, ?)");
		$stmt->execute(array($photo, $restaurantId, $username));
		 
		// Review
		$stmt = $db->prepare("INSERT INTO Review VALUES (null, ?, ?, ?, ?, ?)");
		$stmt->execute(array($username, $restaurantId, $rating, $text, $date));
		
		echo $restaurant . " " . $username . " " .  $text . " " .  $rating . " " . $date . " " . $photo;
	}
?>