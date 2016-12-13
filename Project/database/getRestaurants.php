<?php
include_once('my_database/restaurant.php');

if (isset ($_GET["search"] ) && isset ($_GET["mode"] ))
{
    $search = trim(strip_tags($_GET["search"]));
    $mode = trim(strip_tags($_GET["mode"]));
}
else
    die(header('Location: ' . $_SERVER["HTTP_REFERER"]));


$result = getAllRestaurants();

if(empty($result))
{
    echo 'No restaurants match the search.';
    exit;
}
$selected_restaurants = array();

foreach($result as $row)
{
    if($mode)        //estamos a procura do codigo de postal
    {
        $postCode = $row['postCode'];

        $searchPostCode = substr($search,0, 4);
        $zip = substr($postCode,0, 4);

        if(preg_match("#$searchPostCode#i",$zip))
            $selected_restaurants[] = $row['name'];
    }
    else   //estamos a procura do nome
    {
        $name = $row['name'];
        if(preg_match("#$search#i",$name))
            $selected_restaurants[] = $name;
    }
}

echo json_encode($selected_restaurants);
?>
