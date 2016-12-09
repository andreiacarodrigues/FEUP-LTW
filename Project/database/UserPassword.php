<?php
include_once('Connection.php');

global $db;
$username = $_GET["username"];

$stmt = $db->prepare("SELECT password FROM User WHERE username = ?");
$stmt->execute(array($username));
$info = $stmt->fetch();

if(!empty($info))
    echo json_encode($info['password']);
else
    echo 'INAVALID';
?>