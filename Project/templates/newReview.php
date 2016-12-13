<?php
$token = $_SESSION['csrf_token'];
$newReview ="<div class=\"stars\">
			<form id=\"newReview\" action=\"./database/addReview.php\" method=\"post\" enctype=\"multipart/form-data\">
			    <input type=\"hidden\" name=\"csrf_token\" value= " . $token . "/>
				<input id=\"nr_username\" type=\"hidden\" name=\"username\" value=\"\"/>
				<input id=\"nr_restaurant\" type=\"hidden\" name=\"restaurant\" value=\"\"/>
				<input id=\"nr_text\" type=\"hidden\" name=\"text\" value=\"\"/>
				<input id=\"nr_rating\" type=\"hidden\" name=\"rating\" value=\"\"/>
				<input id=\"nr_date\" type=\"hidden\" name=\"date\" value=\"\"/>
				<label>Rating: <br> <!-- só para não parecer estranho -> tirar no futuro quando se arranjar o css -->
					<input class=\"star star-5\" id=\"star-5\" type=\"radio\" name=\"star\"/>
					<label class=\"star star-5\" for=\"star-5\"></label>
					<input class=\"star star-4\" id=\"star-4\" type=\"radio\" name=\"star\"/>
					<label class=\"star star-4\" for=\"star-4\"></label>
					<input class=\"star star-3\" id=\"star-3\" type=\"radio\" name=\"star\"/>
					<label class=\"star star-3\" for=\"star-3\"></label>
					<input class=\"star star-2\" id=\"star-2\" type=\"radio\" name=\"star\"/>
					<label class=\"star star-2\" for=\"star-2\"></label>
					<input class=\"star star-1\" id=\"star-1\" type=\"radio\" name=\"star\"/>	
					<label class=\"star star-1\" for=\"star-1\"></label>
				</label><br>
				<label>
					Opinion: <br>
					<textarea id=\"review\" name=\"review\" col=\"30\" rows=\"5\"></textarea>
				</label>
				<div id=\"submitReview\">
				</br>
				 <input type=\"file\" name=\"image\" id=\"reviewPic\" class=\"inputfile\" />
				<label for=\"reviewPic\">Select Image</label>
				 <br>
				 <div id=\"buttonSubmitReview\">
				<input type=\"submit\" onclick=\"submitReview()\" value=\"Submit Review\" > <!-- erro aqui -->
				<br>
				</div>
				</div>
			</form>
		</div>
		<span id=\"r_status\"></span>";
		
echo $newReview;
?>