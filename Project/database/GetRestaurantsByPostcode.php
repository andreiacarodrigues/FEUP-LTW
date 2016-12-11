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
    $searchPostCode = substr($search,0, 4);
    $postCode = $row['postCode'];

    $zip = substr($postCode,0, 4);
    if(preg_match("#$searchPostCode#i",$zip))
    {
        $selected_restaurants[] = $row['name'];
    }
}

echo json_encode($selected_restaurants);
?>