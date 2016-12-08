<?php
$info = $_GET['info'];
$owner = $_GET['owner'];
$username = $_GET['username'];

$review =
    "<article id=\"" . $info[0] . "\">
		<ul>
			<li id=\"rev_username\">" . $info[1] . "</li>
			<label>Rating: <li id=\"rev_rating\">" . $info[2]. "</li></label>
			<label>Review: <li id=\"rev_opinion\">" . $info[3] . "</li>
			<li id=\"rev_photos\">";

if(!empty($info[4]))
{
    foreach ($info[4] as $photo)
        $review = $review . "<img src=\"" . $photo . "\"alt=\"Review Photo\">";
}

$review = $review .
    "</li>
		</ul>
		
		<footer>
			<span class=\"date\">" . $info[5] . "</span><br>
			<a href=\"#comments" . $info[0] . "\">Comentários</a>
			<section id=\"comments" . $info[0] . "\">";

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

if($owner == $username)
{
    $review = $review .
        "<a href=\"#reply" . $info[0] . "\">Responder</a>
			<form id=\"reply" . $info[0] . "\" class= \"reply\">
				<textarea id=\"newReview" . $info[0] . "\" cols=\"40\" rows=\"5\"></textarea><br>
				<input type=\"button\" onclick=\"submitReply(" . $info[0] . ")\" value=\"Submeter\">
				<input type=\"button\" onclick=\"cancelReply(" . $info[0] . ")\" value=\"Cancelar\"><br>
				<span id=\"r_status" . $info[0] . "\"></span>
			</form>";
}

$review = $review .
    "</footer>
		</article>";

echo $review;
?>