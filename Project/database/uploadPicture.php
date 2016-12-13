<?php
  include_once('my_database/connection.php');
  global $db;
	
  // possible PHP upload errors 
  $errors = array(1 => 'php.ini max file size exceeded', 
                2 => 'html form max file size exceeded', 
                3 => 'file upload was only partial', 
                4 => 'no file was attached');

  if (isset($_POST["method"]) && isset($_POST["val"]) )
  {
      $method = trim(strip_tags($_POST["method"]));
      $val = trim(strip_tags($_POST["val"]));
  }
  else
  {
      die(header('Location: ' . $_SERVER["HTTP_REFERER"]));
  }

  $filePath = realpath($_FILES["image"]["tmp_name"]);
	 
  echo $_FILES['image']['name'];

  if($val == "NULL")
	  die(header('Location: ' . $_SERVER["HTTP_REFERER"]));
  else
  {
	 // check that the file we are working on really was the subject of an HTTP 
	 if(!@is_uploaded_file($_FILES['image']['tmp_name']))
	 {
		die(header('Location: ' . $_SERVER["HTTP_REFERER"] ));
	 }
	 else
	 // getimagesize() returns false if the file tested is not an image. 
	if(!@getimagesize($filePath))
	{
		die(header('Location: ' . $_SERVER["HTTP_REFERER"] ));
	}
	 else if(exif_imagetype($filePath) != IMAGETYPE_JPEG) {
		die(header('Location: ' . $_SERVER["HTTP_REFERER"] ));
	 }
	else
	{
	  $stmt = $db->prepare("INSERT INTO Photo VALUES(NULL,?)");
	  $stmt->execute(array(""));
	  $id = $db->lastInsertId();
	  
	  $stmt = $db->prepare("UPDATE Photo SET filename = ? WHERE photoId = ?");
	  $stmt->execute(array("$id.jpg", $id));
	  
	  $originalFileName = "../css/images/$id.jpg";
	  $smallFileName = "../css/images_small/$id.jpg";
	  $mediumFileName = "../css/images_medium/$id.jpg";
	  
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

      if($method == 1)
      {
          header('Location: updateUPP.php?val=' . $val . "&id=" . $id);
          exit;
      }
	  if($method == 2)
	  {
		header('Location: updateRPP.php?val=' . $val . "&id=" . $id);
		exit;
	  }
	  if($method == 4)
	  {
		  header('Location: updateRP.php?val=' . $val . "&id=" . $id);
	  }
	   if($method == 5)
	  {
		  header('Location: updateRM.php?val=' . $val . "&id=" . $id);
	  }
	}
  }
  //header('Location: ' . $_SERVER["HTTP_REFERER"] );
  //exit;
?>
