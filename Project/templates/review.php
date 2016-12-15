<?php
$info = json_decode(stripslashes($_GET['info']));


if (isset ( $_GET ["username"] ) && isset ( $_GET ["isRestaurant"] ))
{

	$username = trim(strip_tags($_GET["username"]));
	$isRestaurant = trim(strip_tags($_GET["isRestaurant"]));

	$review =
		"<article id=\"" . $info[0] . "\">
			<ul>";

	if($isRestaurant)
        $review = $review . "<a href=\"userProfile.php?username=" . $info[1] . "\" id=\"rev_username\">" . $info[1] . "</a><br>
				    <li><label for=\"rev_rating\">Rating: <span id=\"rev_rating\">" . $info[2]. "</span></label></li>";
	else
        $review = $review . "<a href=\"restaurantProfile.php?restaurant=" . $info[1] . "\" id=\"rev_username\">" . $info[1] . "</a><br>
				    <li><label for=\"rev_rating\">Rating: <span id=\"rev_rating\">" . $info[2]. "</span></label></li>";

    if($info[3] != "")
		$review = $review ."<li><label for=\"rev_opinion\">Review: <span id=\"rev_opinion\">" . $info[3] . "</span></label></li>";

	if(count($info[4]) != 0)
	{
		$review = $review . "<li id=\"rev_photos\">";
		foreach ($info[4] as $photo)
			$review = $review . "<img src=\"./css/images_small/" . $photo . "\"alt=\"Review Photo\">";
	}

	if(!empty($info[6])) 
		$n_comments = count($info[6]);
	else
		$n_comments = 0;

	$review = $review .
		"</li>
			</ul>
			
			<div id=\"footer\">
				<p class=\"date\">" . $info[5] . "</p><br>
				<a href=\"#comments" . $info[0] . "\"onclick=\"openComments(" . $info[0] . ");\" id = \"r_comments\">Comments(" . $n_comments . ")</a>
				<section id=\"comments" . $info[0] . "\" style=\"display:none\">";

	if(!empty($info[6])) 
	{
		foreach ($info[6] as $reply)
		{
			$review = $review .
				"<ul class=\"comment\">
								<li><label for=\"username\">Username: <span id=\"username\">" . $reply[0] . "</span></label></li>
								<li><label for=\"text\">Comment: <span id=\"text\">" . $reply[1] . "</span></label></li>";
								
				if($reply[0] == $username)
				{
					$review = $review . "<input type=\"button\" onclick=\"deleteReviewReply(" . $info[0] . ", '" . $reply[0] . "', '" . $reply[1] . "');\" value=\"Delete\">";
				}
			$review = $review .	"</ul>";
		}
	}


	$review = $review . "</section>";


		$review = $review .
			"<a href=\"#reply" . $info[0] . "\" onclick=\"openReply(" . $info[0] . ");\">Reply</a><br>
				<form id=\"reply" . $info[0] . "\" class= \"reply\" style=\"display:none\">
					<textarea id=\"newReview" . $info[0] . "\" cols=\"40\" rows=\"5\"></textarea><br>
					<input type=\"button\" onclick=\"submitReply(" . $info[0] . ");\" value=\"Submit Reply\">
					<input type=\"button\" onclick=\"openReply(" . $info[0] . ");\" value=\"Cancel\"><br>
					<p id=\"r_status" . $info[0] . "\"></p>
				</form>";


	if($info[1] == $username)
	{
		 $review = $review . "<input type=\"button\" id=\"reviewDel\" onclick=\"deleteReview(" . $info[0] . ");\" value=\"Delete\">";
	}

	$review = $review .
		"</div>
			</article>";

	echo $review;
}
?>