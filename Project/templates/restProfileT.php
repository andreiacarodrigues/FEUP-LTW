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
				
				var restaurantId = info[0];
				
                _("description").innerHTML = info[1];
                _("location").innerHTML = info[2];
                _("contact").innerHTML = info[3];
                _("avgPrice").innerHTML = info[4];
                _("schedule").innerHTML = info[5];
				_("observations").innerHTML = info[6];
				
				var menuId = info[7];
				var photoId = info[8];
	
				if(photoId != null)
				{
					getPhoto(parseInt(photoId), false);
				}
				else
					$('#main').prepend('<img src="./css/Images/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
				
				if(menuId != null)
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
					$('#options').html('<li><a href="#newReview">Leave Review</a></li>');
					$('#options').append('<li><a href="#">Fast Review</a></li>');
				}
				
				getReviews(owner);
						   
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

	
	function getReviews(owner) // Reviews section and all photos taken by costumers go automatically to the Photos section
	{
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
					
				for(var i = 0; i < info.length; i++)
				{
							
					$('#reviews').append('<article id=' + info[i][0] + '>\n<ul>\n<li id="rev_username">' + info[i][1] + '</li>\n<label>Rating: <li id="rev_rating">' + info[i][2] + '</li></label>\n<label>Review: <li id="rev_opinion">' + info[i][3] + '</li>\n<li id="rev_photos">\n</li>\n</ul>\n');
			
					var photos = info[i][4];
					for(var j = 0; j < photos.length; j++)
					{
						var photoInsertText = '<img src="'+ photos[j] + '"alt="Review Photo">';
						$('#reviews > #' + info[i][0] + ' #rev_photos').append(photoInsertText);
						$('#photos').append(photoInsertText);
					}
					
					$('#reviews').append('<footer>');
					$('#reviews').append('<span class="date">' + info[i][5] + '</span><br>'); // date
						
					if(owner == username)
					{
						$('#reviews').append('<a href="#reply' + info[i][0] + '">Responder</a><form id="reply' + info[i][0] + '" class= "reply"><textarea id="newReview' + info[i][0] + '" cols="40" rows="5"></textarea><br><input type="button" onclick="submitReply(' + info[i][0] +')" value="Submeter"><input type="button" onclick="" value="Cancelar"><br><span id="r_status' + info[i][0] + '"></span></form>'); // duvidas aqui em questão do link ser necessário para fazer o acordeão

					}
					$('#reviews').append('</footer>\n</article>\n');
						
					//alert($('#reviews').html());
				}
				console.log($('#reviews').html());
				return true;	
            }
        };

        xmlhttp.open("GET","database/RestaurantReviews.php?restaurant="+ restaurant,true);
        xmlhttp.send();
	}
	
	function submitReply(i)
	{
		var r = i;
		var u = username; //owner
		var t = _("newReview" + i).value;
		var r_status = _("r_status" + i);

		if(t == "")
			r_status.innerHTML = "You can't submit an empty reply.";
		else
		{
			r_status.innerHTML = "";
		
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
		
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$('#newReview' + i ).val('');
				}
			};
			
			xmlhttp.open("GET","database/AddReply.php?id="+r + "&username="+u+"&text="+t,true);
			xmlhttp.send();

		}
		// restrição de owner não poder fazer review do proprio restaurante - TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
	}

/*	isto vai buscar a data -> quando for para adicionar uma review xD

var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '/' +
    (month<10 ? '0' : '') + month + '/' +
    (day<10 ? '0' : '') + day;*/
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
            <a href="#menu">Menu</a>
            <div id = "menu">
            </div>
        </li>
        <li>
            <a href="#reviews">Opiniões</a>
            <div  id="reviews">
				<!--<article>
					<img src="" alt="user foto"> //  - TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
					<ul>
						<li id= "name"></li>  
						<li id= "rating"></li>
						<li id= "opinion"></li>
						<li id= "photos"></li>
					</ul>
					<footer>
						<!-- efeito acordeão para ver os comentarios e para abrir a textarea 
						<span class="date">@May 5th 2014</span><br> <!-- a data ainda nao esta implementada
						<a href="#reply' + i + '">Responder</a>
						<form id="reply' + i + '">
							<textarea name="newReview" cols="40" rows="5"></textarea> <br>
							<input type="button" onclick="" value="Submeter">
							<input type="button" onclick="" value="Cancelar">
							<br><span id="r_status + i'"></span>
						</form>
					</footer>
				</article> -->
            </div>
        </li>
        <li>
            <a href="#photos">Fotos</a>
            <div id="photos">
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