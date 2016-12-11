<?php
include_once('Connection.php');

    function addReviewReply($id,$username,$text)
    {
        global $db;
        $stmt = $db->prepare("INSERT INTO ReviewReply VALUES (?, ?, ?)");
        $stmt->execute(array($id, $username, $text));
    }

    function getReviewReply()
    {
        global $db;
        $stmt = $db->prepare('SELECT reviewId,username,text FROM ReviewReply');
        $stmt->execute(array());
        return $stmt->fetchAll();
    }

    function addReview($username,$restaurantId,$rating,$text,$date)
    {
        global $db;
        $stmt = $db->prepare("INSERT INTO Review VALUES (null, ?, ?, ?, ?, ?)");
        $stmt->execute(array($username, $restaurantId, $rating, $text, $date));
    }

    function getFirstReviewId()
    {
        global $db;
        $stmt = $db->prepare("SELECT reviewId FROM Review ORDER BY reviewId DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

?>