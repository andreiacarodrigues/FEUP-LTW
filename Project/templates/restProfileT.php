<?php
if (isset ( $_GET ["restaurant"] ))
{
    $restaurant = $_GET ["restaurant"];

	if (isset ( $_SESSION ["userid"] ))
		$username = $_SESSION ["userid"];
	else
		$username = "NULL";
}
else
    die();
?>

<script language="JavaScript">

	var username = <?php echo json_encode($username) ?>;
	var restaurant = <?php echo json_encode($restaurant) ?>;
	
    function _(x){
        return document.getElementById(x);
    }

    function getInfo(){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				var info = new String(this.responseText);
				info = info.trim();
				
				console.log(info);
				if(info == "INVALID")
					return false;
				else
					info = eval("(" + this.responseText + ")"); 
				
                _("name").innerHTML = restaurant;
				
				var restaurantId = info[0];
				
                _("description").innerHTML = info[1];
                _("location").innerHTML = info[2];
                _("contact").innerHTML = info[3];
                _("avgPrice").innerHTML = info[4];
                _("schedule").innerHTML = info[5];
				_("observations").innerHTML = info[6];
				
				var menuId = info[7]; // colocar menuId e photo Id
				var photoId = info[8];
				
				console.log(menuId);
				console.log(photoId);
				if(photoId != "NULL")
				{
					getPhoto(parseInt(photoId), false);
				}
				else
					$('#main').prepend('<img src="./css/Images/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
				
				if(menuId != "NULL")
				{
					getPhoto(parseInt(menuId) , true);
				}
				else
					$('#menu').html('<img src="./css/Images/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
				
				var rating_sum = info[9];
				var rating_total = info[10];
				var rating = Math.round((parseFloat(rating_sum) / parseFloat(rating_total)) * 100) / 100
                _("rating").innerHTML = rating; 
             
				var owner = info[11];
			    _("owner").innerHTML = owner;
			   
			    if(username == owner)
			    {
					$('#options').html('<li><a href="#">Edit</a></li>');
			    }
			    else
				{
					$('#options').html('<li><a href="#LeaveReview">Leave Review</a></li>');
					$('#options').append('<li><a href="#">Fast Review</a></li>');
				}
						   
			   return true;
            }
        };

        xmlhttp.open("GET","database/RestaurantInfo.php?restaurant="+ restaurant,true);
        xmlhttp.send();
    }
	
	function getPhoto(id, isMenu)
	{
		 if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
				var filename = new String(this.responseText);
				filename = filename.trim();
				
				console.log(filename);
				if(filename == "INVALID")
					return false;
				
				if(isMenu)
				{
					var s1 = '<img src="./css/Images/';
					var s2 = 'alt="Photo that represents the restaurant">';
					s1.concat(filename);
					s1.concat(s2);
					
					alert(s1);
					$('#menu').html('<img src='+ filename + 'alt="Photo that represents the restaurant">');
					
					alert($('#menu').html());
				}
				else
				{
					$('#main').prepend('<img src=' + filename + 'alt="Photo that represents the restaurant">');
				}
				
			   return true;
            }
        };

        xmlhttp.open("GET","database/GetPhoto.php?id="+ id,true);
        xmlhttp.send();
	}

</script>

<section id="main" >
    <h2 id="name">Restaurant Name</h2>  
    <h3 id="rating">Rating</h3>            
    <div id = "options"> </div>
</section>
<section id="Details">
    <ul id="tabs">
        <li id="informations">
            <a href="#">Informations</a> <!-- isto é estatico portanto temos de fazer disable disto pelo css -->
            <div>
                <ul id="info">
					<label>Description: <li id="description"></li></label>
					<label>Location: <li id = "location"> </li></label>
					<label>Schedule: <li id="schedule"></li></label>
					<label>Average Price Per Person: <li id = "avgPrice"></li></label>
                    <label>Contact:<li id = "contact"> </li> </label>
					<label>Observations: <li id="observations"></li></label>
					<label>Owner: <li id="owner"></li></label>
                </ul
            </div>
        </li>
        <li>
            <a href="#Menu">Menu</a>
            <div id = "menu">
            </div>
        </li>
        <li  id="reviews">
            <a href="#Reviews">Opiniões</a>
            <div>
                <!-- lista de todas as revies -->
                <!-- review esta no ficheiro review.php -->
            </div>
        </li>
        <li  id="photos">
            <a href="#Photos">Fotos</a>
            <div>
                <!-- vai conter várias imagens em miniatura que vêm da bd-->
            </div>
        </li>
    </ul>
</section>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"> <!-- para css das estrelas -->

<section id="newReview">
	<div class="stars">
		<form>
			<label>Rating: <br> <!-- só para não parecer estranho -> tirar no futuro quando se arranjar o css -->
				<input class="star star-5" id="star-5" type="radio" name="star"/>
				<label class="star star-5" for="star-5"></label>
				<input class="star star-4" id="star-4" type="radio" name="star"/>
				<label class="star star-4" for="star-4"></label>
				<input class="star star-3" id="star-3" type="radio" name="star"/>
				<label class="star star-3" for="star-3"></label>
				<input class="star star-2" id="star-2" type="radio" name="star"/>
				<label class="star star-2" for="star-2"></label>
				<input class="star star-1" id="star-1" type="radio" name="star"/>	
				<label class="star star-1" for="star-1"></label>
			</label>
			<label>
				Opinion:
				<textarea class="review" name="review" col="30" rows="5"></textarea>
			</label>
			</br>
			<label>
				Add Picture:
				<input type="file" name="reviewPic" id="reviewPic">
			</label>
			<button type="button" onclick=""> Submit
		</form>
	</div>
</section>

<script language="JavaScript">
$(document).ready(getInfo());

</script>