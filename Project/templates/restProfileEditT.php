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
			
				if(info == "INVALID")
					return false;
				else
					info = eval("(" + this.responseText + ")"); 
				
                _("name").innerHTML = restaurant;
				$('#r_name').attr("placeholder", restaurant);
				$('#r_description').attr("placeholder", info[1]);
				$('#r_location').attr("placeholder", info[2]);
				$('#r_contact').attr("placeholder", info[3]);
				$('#r_avgPrice').attr("placeholder", info[4]);
				$('#r_schedule').attr("placeholder", info[5]);
				$('#r_observations').attr("placeholder", info[6]);
				
				var menuId = info[7];
				var photoId = info[8];
	
				if(photoId != null)
				{
					getPhoto(parseInt(photoId), false);
				}
				else
					$('#main').prepend('<img src="./css/Images/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');/*
				
				if(menuId != null)
				{
					getPhoto(parseInt(menuId) , true);
				}
				else
					$('#menu').html('<img src="./css/Images/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
				*/
			/*	var rating_sum = info[9];
				var rating_total = info[10];
				var rating = Math.round((parseFloat(rating_sum) / parseFloat(rating_total)) * 100) / 100
                _("rating").innerHTML = rating; 
             
				var owner = info[11];
			    _("owner").innerHTML = owner;
			   
			    if(username == owner)
			    {
					$('#options').html('<li><a href="restaurantProfileEdit.php?restaurant=' + restaurant +'">Edit</a></li>');
			    }
			    else
				{
					$('#options').html('<li><a href="#newReview">Leave Review</a></li>');
					$('#options').append('<li><a href="#">Fast Review</a></li>');
				}
				
				getReviews(owner);
				
				if(owner != username)
				{
					console.log("vai mostrar:o");
					showNewReview();
				}
						   */
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
				var filename = new String(this.responseText);
				filename = filename.trim();

				if(filename == "INVALID")
					return false;
				
				if(isMenu)
					$('#menu').html('<img src='+ filename + 'alt="Photo that represents the restaurant">');
				else
					$('#main').prepend('<img src=' + filename + 'alt="Photo that represents the restaurant">');
				
			   return true;
            }
        };

        xmlhttp.open("GET","database/GetPhoto.php?id="+ id,true);
        xmlhttp.send();
	}
	
	function myFunction() {
    var popup = document.getElementById('myPopup');
    popup.classList.toggle('show');
}

</script>

<section id="main" >
	<input type="button" onclick="submitChanges()" value="Change Picture"/>  
	<input type="button" onclick="submitChanges()" value="Delete Picture"/>  
	<h2 id="name">Restaurant Name</h2>   
</section>
<section id="details">
    <ul id="tabs">
        <li id="informations">
            <a href="#informations">Informations</a>
            <div>
                <form>
                    <label>Restaurant Name: <input id="r_name" type="text" maxlength="60"> </label><br>
                    <label>Description: <textarea  id="r_description"name="description" cols="60" rows="2"></textarea> </label> <br>
                    <label>Location:<input id="r_location" type="text" name="adress" maxlength="80"></label><br>
					<label>Schedule:<input id="r_schedule" type="text" name="schedule"></label><br>
                    <label>Average Price Per Person(€):<input id="r_avgPrice" type="text" name="cost" maxlength="4"></label> <br>
                    <label>Contact:<input id="r_contact" type="tel" name="number" maxlength="9"></label> <br>
					<label>Observations: <textarea id="r_observations" name="review" cols="60" rows="2"></textarea></label> 
					<div class="popup" onclick="myFunction()">?
						<span class="popuptext" id="myPopup">You can allow your customers to know if your restaurant has: wi-fi, takeAway, live music, vegan menu options, wheelchair access, bar, etc.</span>
					</div><br>
                    <input type="button" onclick="submitChanges()"/ value="Submit Changes">  
					<input type="button" onclick="goBack()" value="Cancel"/>  
                </form>
				
				
			</div>
			
        </li>
		
		
        <li  id="menu">
            <a href="#menu">Menu</a>
            <div>
                <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
                  Select image to upload:
                  <input type="file" name="fileToUpload" id="fileToUpload">
                  <input type="submit" value="Upload Image" name="submit">
              </form>-->
                <!-- pode eliminar as suas imagens ou adicionar novas-->
            </div>
        </li>
        <li  id="photos">
            <a href="#photos">Photos</a>
            <div>
                <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
                     Select image to upload:
                     <input type="file" name="fileToUpload" id="fileToUpload">
                     <input type="submit" value="Upload Image" name="submit">
                 </form>-->

                <!-- pode eliminar as suas imagens ou adicionar novas-->
            </div>
        </li>
    </ul>
</section>

<script language="JavaScript">
$(document).ready(getInfo());
</script>

<!--<label>Tipos de cozinha: <!-- fazer inserts com isto na base de dados logo ao inicio. o "outro" insere um novo tipo na bd e passa a estar nesta lista
                        <select name="cuisine" multiple = "multiple">
                            <option value="portuguesa">Portuguesa</option>
                            <option value="mediterranica">Mediterrânica</option>
                            <option value="contemporanea">Contemporânea</option>
                            <option value="vegetariana">Vegetariana</option>
                            <option value="pizzaria">Pizzaria</option>
                            <option value="hamburgeria">Hamburgeria</option>
                            <option value="marisqueira">Marisqueira</option>
                            <option value="internacional">Internacional</option>
                            <option value="japonesa">Japonesa</option>
                            <option value="francesa">Francesa</option>
                            <option value="italiana">Italiana</option>
                            <option value="chinesa">Chinesa</option>
                            <option value="japonesa">Japonesa</option>
                        </select>
                        <label>Outro:
                            <input type="text" name="newCuisine">
                        </label>
                    </label>-->