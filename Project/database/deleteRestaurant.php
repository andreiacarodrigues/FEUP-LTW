<?php
include_once('my_database/restaurant.php');

if (isset ($_GET["restaurant"] ))
{
    $restaurant = trim(strip_tags($_GET["restaurant"]));

	$result = deleteRestaurant($restaurant);

	if($result)
		header('Location: ../userProfile.php?username=' . $username);
	}
else
    echo "INVALID";
?>
