<?php
include_once('Connection.php');

function addUser($name, $email, $birthdate,$postCode, $username, $password, $options)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO user VALUES (null, ?, ?, ?, ?, ? ,?, null)");
    $stmt->execute(array($name, $email, $birthdate, $postCode,$username, password_hash($password, PASSWORD_DEFAULT, $options)));
}

function getUserPassword($username)
{
    global $db;
    $stmt = $db->prepare("SELECT password FROM User WHERE username = ?");
    $stmt->execute(array($username));
    return $stmt->fetch();
}

function getUserInfo($username)
{
    global $db;
    $stmt = $db->prepare("SELECT name, email, birthdate, postCode, photoId FROM User WHERE username = ?");
    $stmt->execute(array($username));
    return $stmt->fetch();
}

function getUserPhoto($name)
{
    global $db;
    $stmt = $db->prepare("SELECT photoId from User WHERE username = ?");
    $stmt->execute(array($name));
    return $stmt->fetch();
}

function updateUser($name, $email, $birthdate, $postCode, $username, $previousUsername)
{
    global $db;
    $stmt = $db->prepare("UPDATE User SET name = ? , email = ? , birthdate = ? , postCode = ?, username = ? WHERE username = ?");
    $stmt->execute(array($name, $email, $birthdate, $postCode, $username, $previousUsername));
}

function updateUserPassword($password,$options,$username)
{
    global $db;
    $stmt = $db->prepare("UPDATE User SET password = ? WHERE username = ?");
    $stmt->execute(array(password_hash($password, PASSWORD_DEFAULT, $options) , $username));
}

function updateUserPhoto($id,$name)
{
    global $db;
    $stmt = $db->prepare("UPDATE User SET photoId = ? WHERE username = ?");
    $stmt->execute(array($id, $name));
}

//========================================================================

/*function getAllUsers()
{
    global $db;
    $stmt = $db->prepare("SELECT name, email, birthdate, postCode, username, password, photoId FROM User");
    $stmt->execute();
    $users = $stmt->fetchAll();
    return $users;
}

function deleteUser($username)
{
    global $db;
    $stmt = $db->prepare("DELETE FROM User WHERE username = ?");
    return $stmt->execute(array($username));
}

function userExists($username)
{
    global $db;

    $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array($username));
    return $stmt->fetch() !== false;
}

function getAllReviews($username)
{
    global $db;

    $stmt = $db->prepare('SELECT reviewId, restaurantId, rating, text FROM Review WHERE username = ?');
    $stmt->execute(array($username));
    return $stmt->fetch();
}

function getRestaurantInfo($restId)
{
    global $db;

    $stmt = $db->prepare('SELECT name, location, photoId, rating_total FROM Restaurant WHERE restaurantId = ?');
    $stmt->execute(array($restId));

    if($stmt->fetch() === false)
        return null;

    return $stmt->fetch();
}

function getPhotoFromUserToRest($restId,$username)
{
    global $db;

    $stmt = $db->prepare('SELECT photoID FROM ReviewPhoto WHERE restaurantId = ? AND username = ?');
    $stmt->execute(array($restId,$username));
    return $stmt->fetch();
}

function getPhotoPath($photoId)
{
    global $db;

    $stmt = $db->prepare('SELECT filename FROM Photo WHERE photoId = ?');
    $stmt->execute(array($photoId));
    return $stmt->fetch();
}

function getAllRestaurantsOwner($username)
{
    global $db;

    $stmt = $db->prepare('SELECT restaurantId FROM Restaurant WHERE ownerId = ?');
    $stmt->execute(array($username));
    return $stmt->fetch();
}

function isOwner($username)
{
    global $db;

    $stmt = $db->prepare('SELECT restaurantId FROM Restaurant WHERE ownerId = ?');
    $stmt->execute(array($username));
    return $stmt->fetch() !== false;    //retorna true se for owner
}
*/
?>