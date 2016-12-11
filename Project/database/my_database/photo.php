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
        $stmt = $db->prepare("DELETE FROM Photo WHERE photoId = ?");
        $stmt->execute(array($deleteId));

        unlink("../../css/images/$deleteId.jpg");
        unlink("../../css/images_small/$deleteId.jpg");
        unlink("../../css/images_medium/$deleteId.jpg");
    }

    function addPhoto(){

    }

?>
