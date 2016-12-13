<?php
include_once('Connection.php');

function addReviewReply($id,$username,$text)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO ReviewReply VALUES (?, ?, ?)");
    $stmt->execute(array($id, $username, $text));
}

function getAllReviewReply()
{
    global $db;
    $stmt = $db->prepare('SELECT reviewId,username,text FROM ReviewReply');
    $stmt->execute(array());
    return $stmt->fetchAll();
}

function getReviewReply($review)
{
    global $db;
    $stmt = $db->prepare('SELECT username, text FROM ReviewReply WHERE reviewId = ? ');
    $stmt->execute(array($review));
    return $stmt->fetchAll();
}

function deleteReviewReply($id, $username, $text)
{
    global $db;
    $stmt = $db->prepare('DELETE FROM ReviewReply WHERE reviewId = ? AND username = ? AND text = ?');
    return $stmt->execute(array($id, $username, $text));
}

//----------------------------------------

function addReview($username,$restaurantId,$rating,$text,$date)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO Review VALUES (null, ?, ?, ?, ?, ?)");
    $stmt->execute(array($username, $restaurantId, $rating, $text, $date));
	
	$stmt = $db->prepare("SELECT rating_sum, rating_total FROM Restaurant WHERE restaurantId = ? ");
	$stmt->execute(array($restaurantId));
	$restaurantInfo = $stmt->fetch();
	
	$stmt = $db->prepare("UPDATE Restaurant SET rating_total = ? , rating_sum = ? WHERE restaurantId = ?");
    $stmt->execute(array($restaurantInfo['rating_total'] + 1, $restaurantInfo['rating_sum'] + $rating, $restaurantId));
	
	return $restaurantInfo;
}

function deleteReview($id)
{
    global $db;
    $stmt = $db->prepare("DELETE FROM Review WHERE reviewId = ?;");
    return $stmt->execute(array($id));
}

function getFirstReviewId()
{
    global $db;
    $stmt = $db->prepare("SELECT reviewId FROM Review ORDER BY reviewId DESC LIMIT 1");
    $stmt->execute();
    return $stmt->fetch();
}

function getReviewsByRestaurant($restaurantId)
{
    global $db;
    $stmt = $db->prepare('SELECT reviewId, username, rating, text, date FROM Review WHERE restaurantId = ?');
    $stmt->execute(array($restaurantId));
    return $stmt->fetchAll();
}

function getReviewsByUser($username)
{
    global $db;
    $stmt = $db->prepare('SELECT reviewId, restaurantId, rating, text, date FROM Review WHERE username = ?');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

//------------------------

function getReviewPhoto($review)
{
    global $db;
    $stmt = $db->prepare('SELECT photoId FROM ReviewPhoto WHERE reviewId = ?');
    $stmt->execute(array($review));
    return $stmt->fetchAll();
}

function addReviewPhoto($reviewId,$photo)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO ReviewPhoto VALUES (?, ?)");
    $stmt->execute(array($reviewId, $photo));
}

?>