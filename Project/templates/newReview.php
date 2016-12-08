<?php
$newReview ="<div class=\"stars\">
			<form>
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
					Opinion:
					<textarea id=\"review\" name=\"review\" col=\"30\" rows=\"5\"></textarea>
				</label>
				</br>
				<label>
					 Select images: <input type=\"file\" name=\"reviewPic[]\" id=\"reviewPic\" multiple> <!-- not sure what to do here -->
				</label> <br>
				<button type=\"button\" onclick=\"submitReview()\"> Submit <!-- erro aqui -->
				<br>
				<span id=\"r_status\"></span>
			</form>
		</div>";
		
echo $newReview;
?>