<?php
$info = json_decode(stripslashes($_GET['info']));

/*
if ((isset ( $_GET ["owner"] )) && (isset ( $_GET ["username"] )))
{
    $owner = trim(strip_tags($_GET["owner"]));
    $username = trim(strip_tags($_GET["username"]));
}
*/

$review =
    "<article id=\"" . $info[0] . "\">
		<ul>
			<a href=\"restaurantProfile.php?restaurant=" . $info[1] . "\" id=\"rev_username\">" . $info[1] . "</a><br>
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
			<span class=\"date\">" . $info[5] . "</span><br>
			<a href=\"#comments" . $info[0] . "\" onclick=\"openComments(" . $info[0] . ")\">Comentários(" . $n_comments . ")</a>
			<section id=\"comments" . $info[0] . "\" style=\"display:none\">";

if(!empty($info[6])) 
{
    foreach ($info[6] as $reply)
    {
        $review = $review .

            "<ul class=\"comment\">
							<li id=\"username\">" . $reply[0] . "</li>
							<li id=\"text\">" . $reply[1] . "</li>
						</ul>";
    }
}


$review = $review . "</section>";

//if($owner == $username)
//{
    $review = $review .
        "<a href=\"#reply" . $info[0] . "\">Responder</a>
			<form id=\"reply" . $info[0] . "\" class= \"reply\">
				<textarea id=\"newReview" . $info[0] . "\" cols=\"40\" rows=\"5\"></textarea><br>
				<input type=\"button\" onclick=\"submitReply(" . $info[0] . ")\" value=\"Submeter\">
				<input type=\"button\" onclick=\"cancelReply(" . $info[0] . ")\" value=\"Cancelar\"><br>
				<span id=\"r_status" . $info[0] . "\"></span>
			</form>";
//}

$review = $review .
    "</div>
		</article>";

echo $review;
?>