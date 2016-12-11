<?php
include_once('my_database/Restaurant.php');

$search = $_GET["search"];

$result = getAllRestaurants();

if(empty($result))
{
    echo 'No restaurants match the search.';
    exit;
}
$selected_restaurants = array();

foreach($result as $row) {
    $name = $row['name'];
    if(preg_match("#$search#i",$name))
    {
        $selected_restaurants[] = $name;
    }
}

echo json_encode($selected_restaurants);
?>