<?php
include_once('connection.php');
include_once('my_database/photo.php');
include_once('my_database/user.php');
include_once('my_database/reviews.php');

function addRestaurant($name,$description,$location,$postCode,$schedule,$avgPrice,$contact,$observation,$owner)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO Restaurant VALUES (null, ?, ?, ?, ?, ? ,?, ?, ?, null, null, 0, 0, ?)");
    return $stmt->execute(array($name, $description, $location, $postCode,$schedule, $avgPrice, $contact, $observation, $owner));
}

function deleteRestaurant($name)
{
    global $db;
	
	$id =getRestaurantId($name);
	$idMenu = getRestaurantMenu($name);
	$idPhotos = getRestaurantPhotos($name);
	$reviews = getReviewsByRestaurant($id['restaurantId']);
	
    $stmt = $db->prepare("DELETE FROM Restaurant WHERE name = ?");
	$result = $stmt->execute(array($name));
	
	if($result)
	{
		foreach ($idPhotos as $idPhoto)
			$result = deletePhoto($idPhoto['photoId']);
	}
	
	if($result)
		$result = deletePhoto($idMenu['menuId']);
	
	if($result)
	{
	foreach ($reviews as $review)
		$result = deleteReview($review['reviewId']);
	}
	
	return $result;
}


function getRestaurantId($name)
{
    global $db;
    $stmt = $db->prepare("SELECT restaurantId FROM Restaurant WHERE name = ?");
    $stmt->execute(array($name));
    return $stmt->fetch();
}

function getRestaurantName($restaurantId)
{
    global $db;
    $stmt = $db->prepare('SELECT name FROM Restaurant WHERE restaurantId = ?');
    $stmt->execute(array($restaurantId));
    return $stmt->fetch();
}

function getAllRestaurants()
{
    global $db;
    $stmt = $db->prepare("SELECT restaurantId, name, postCode, location FROM Restaurant ORDER BY rating_total");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getRestaurantsByOwner($username)
{
    global $db;
    $stmt = $db->prepare('SELECT name, rating_sum, rating_total, location, photoId FROM Restaurant WHERE owner = ?');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

function getRestaurantsByName($name)
{
    global $db;
    $stmt = $db->prepare("SELECT restaurantId, description, location, contact, avgPrice, schedule, observation, menuId, photoId, rating_sum, rating_total, owner, postCode FROM Restaurant WHERE name = ?");
    $stmt->execute(array($name));
    return $stmt->fetch();
}

function getRestaurantPPhoto($name)
{
    global $db;
    $stmt = $db->prepare("SELECT photoId from Restaurant WHERE name = ?");
    $stmt->execute(array($name));
    return $stmt->fetch();
}

function getRestaurantMenu($name)
{
    global $db;
    $stmt = $db->prepare("SELECT menuId from Restaurant WHERE name = ?");
    $stmt->execute(array($name));
    return $stmt->fetch();
}

function updateRestaurant($name, $description, $location, $contact, $avgPrice, $schedule, $observation, $postCode, $id)
{
    global $db;
    $stmt = $db->prepare("UPDATE Restaurant SET name = ? , description = ? , location = ? , contact = ? , avgPrice = ? , schedule = ? , observation = ?, postCode = ? WHERE restaurantId = ?");
    $stmt->execute(array($name, $description, $location, $contact, $avgPrice, $schedule, $observation, $postCode, $id));
}

function updateRestaurantMenu($id,$name)
{
    global $db;
    $stmt = $db->prepare("UPDATE Restaurant SET menuId = ? WHERE name = ?");
    $stmt->execute(array($id, $name));
}

function updateRestaurantPPhoto($id,$name)
{
    global $db;
    $stmt = $db->prepare("UPDATE Restaurant SET photoId = ? WHERE name = ?");
    $stmt->execute(array($id, $name));
}

//------------------------------------

function addRestaurantPhoto($photoId,$restaurantId)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO RestaurantPhoto VALUES(?,?)");
    $stmt->execute(array($photoId, $restaurantId));
}

function getRestaurantPhotos($restaurantId)
{
    global $db;
    $stmt = $db->prepare('SELECT photoId FROM RestaurantPhoto WHERE restaurantId = ?');
    $stmt->execute(array($restaurantId));
    return $stmt->fetchAll();
}

?>
