<?php
include_once('connection.php');

function getPhoto($id)
{
    global $db;
    $stmt = $db->prepare("SELECT filename FROM Photo WHERE photoId = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
}

function getPhotoByFilename($filename)
{
    global $db;
    $stmt = $db->prepare("SELECT photoId from Photo WHERE filename = ?");
    $stmt->execute(array($filename));
    return $stmt->fetch();
}

function deletePhoto($deleteId)
{
    global $db;
	
	unlink("../../css/images/$deleteId.jpg");
    unlink("../../css/images_small/$deleteId.jpg");
    unlink("../../css/images_medium/$deleteId.jpg");
	
    $stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
    return $stmt->execute(array($deleteId));

}

function addPhoto()
{
    global $db;
    $stmt = $db->prepare("INSERT INTO Photo VALUES(NULL,?)");
    $stmt->execute(array(""));
    $photo = $db->lastInsertId();

    $stmt = $db->prepare("UPDATE Photo SET filename = ? WHERE photoId = ?");
    $stmt->execute(array("$photo.jpg", $photo));

    return $photo;
}

?>
