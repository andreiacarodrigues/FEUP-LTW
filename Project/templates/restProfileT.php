<?php
if (isset ( $_GET ["restaurant"] ))
{
    $restaurant = trim(strip_tags($_GET["restaurant"]));

	if (isset ( $_SESSION ["userid"] ))
		$username = $_SESSION ["userid"];
	else
		$username = "NULL";
	
	if (isset ( $_GET ["errorReview"] ))
        $errorReview = true;
	else
		$errorReview = false;

}
else
{
	 echo 'ACCESS DENIED : you must be logged in to acess this page';
	 die();
}
  
?>

<script language="JavaScript">
	var username = <?php echo json_encode($username) ?>;
	var restaurant = <?php echo json_encode($restaurant) ?>;
	var errorReview = <?php echo json_encode($errorReview) ?>;
    function getInfo(){
		
		openTab('informations');
		
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
                _("description").innerHTML = info[1];
                _("location").innerHTML = info[2];
                _("contact").innerHTML = info[3];
                _("avgPrice").innerHTML = info[4] + '€';
                _("schedule").innerHTML = info[5];
				_("observations").innerHTML = info[6];
				_("postCode").innerHTML = info[12];

				initMap(info[12]);
				
				var menuId = info[7];
				var photoId = info[8];
	
				if(photoId != null)
					getPhoto(parseInt(photoId), false, '#informations', '#menu', './css/images/');
				else
					$('#informations').prepend('<img src="./css/images/1.jpg" alt="Photo that represents the restaurant">');
				
				if(menuId != null)
					getPhoto(parseInt(menuId) , true, '#informations', '#menu', './css/images/');
				else
					$('#menu').html('<img src="./css/images/1.jpg" alt="Photo that represents the restaurant">');
				
				var rating_sum = info[9];
				var rating_total = info[10];
				if((rating_sum == 0) || (rating_total == 0))
					var rating = 0;
				else
					var rating = Math.round((parseFloat(rating_sum) / parseFloat(rating_total)) * 100) / 100;
                _("rating").innerHTML = "Rating: " + rating +  ' ⭐'; 
             
				var owner = info[11];
			    _("owner").innerHTML = owner;
			   
			    if(username == owner)
			    	$('#options').html('<li><a href="restaurantProfileEdit.php?restaurant=' + restaurant +'">Edit</a></li>');
			    else
					$('#options').html('<li><a id="n_Review" href="#newReview">Leave Review</a></li>');
				
				getReviews(owner);
				getPhotos();
				
				if(owner != username)
				{
					showNewReview();
					//$('#newReview').append('<span id=\"r_status\"></span>');
					if(errorReview)
					{
						$('#r_status').html("You need at least to leave a rating if you want to submit a review.");
					}
				}
				
				console.log(document.getElementById("menu").innerHTML);
			   return true;
            }
        };
        xmlhttp.open("GET","database/restaurantInfo.php?restaurant="+ restaurant,true);
        xmlhttp.send();
    }
	function getReviews(owner) 
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
					console.log(info[i]);
					
					var jsonString = JSON.stringify(info[i]);
					//$.get('./templates/review.php',  {info: jsonString, owner: owner , username: username}, function(data)
					$.get('./templates/review.php',  {info: jsonString}, function(data)
					{
						var info = new String(data);
						info = info.trim();
				
						$('#reviews').append(data);
					}
					);
				}
				return true;	
            }
        };
        xmlhttp.open("GET","database/restaurantReviews.php?restaurant="+ restaurant,true);
        xmlhttp.send();
	}
	
	function getPhotos()
	{
		$.get('./database/restaurantPhotos.php',  {restaurant: restaurant}, function(data)
		{
			var info = new String(data);
            info = info.trim();
			
			if(info != "INVALID")
			{
				var photos = eval("(" + info + ")"); 
				for(var i = 0; i < photos.length; i++)
				{
					$('#photos').append('<img src="./css/images/'+ photos[i] + '"alt="Photo of the restaurant">');
				}
			}
		}
	);
	}
	
	function cancelReply(i)
	{
		$('#newReview' + i ).val('');
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
			
			xmlhttp.open("GET","database/addReply.php?id="+r + "&username="+u+"&text="+t,true);
			xmlhttp.send();
		}
	}
	
	function radioListCheck(name) 
	{
		for (var x = 5; x >= 1; x--) { // 5 é o maior rating
			if (document.getElementById(name + '-' + x).checked) {
				return x; // don't know why mas não me dá o valor certo de outra maneira
			}
		}
		return -1;
	}
	function submitReview()
	{
		$('#newReview #nr_username').attr("value", username);
		$('#newReview #nr_restaurant').attr("value", restaurant);
		$('#newReview #nr_text').attr("value", _("review").value);
		
		var rat = radioListCheck("star");
		
		alert(rat);
		var r_status = _("r_status");
	
		if(rat == -1)
		{
			r_status.innerHTML = "You need at least to leave a rating if you want to submit a review.";
		}
		else
			r_status.innerHTML = "";
		
		$('#newReview #nr_rating').attr("value", rat);
		
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var date = d.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;
		
		$('#newReview #nr_date').attr("value", date);
	}
		
   function showNewReview()
   {
		$.get('./templates/newReview.php', function(data) 
		{
			var info = new String(data);
            info = info.trim();
			
			$('#newReview').append(info);
		}
		);
   }
   
   var tabList = ['informations', 'menu', 'reviews', 'photos'];
</script>

<section id="sectionBody">
	
<section id="res" >
	 <section id="menuProfile" >
		<ul>
		<a href="#informations" onclick="openTab('informations')">Informations</a>
		<br>
		<a href="#menu" onclick="openTab('menu')">Menu</a>
		<br>
		<a href="#reviews" onclick="openTab('reviews')">Reviews</a>
		<br>
		<a href="#photos" onclick="openTab('photos')">Photos</a>
		</ul>
	</section>

<section id="Details">
  
        <li id="informations">
		 <h2>Informations</h2>
		 <h3 id="name">Restaurant Name</h3>  
		<h3 id="rating">Rating</h3>      
		<div id ="options"> </div>
            <div>
                <ul id="info">
                    <li><label for="description">Description: <span id="description"></span></label></li>
                    <li><label for="location">Location: <span id="location"></span></label></li>
                    <li><label for="postCode">PostCode: <span id="postCode"></span></label></li>
                    <li id="map"/>
                    <li><label for="schedule">Schedule: <span id="schedule"></span></label></li>
                    <li><label for="avgPrice">Average Price Per Person: <span id="avgPrice"></span></label></li>
                    <li><label for="contact">Contact: <span id="contact"></span></label></li>
                    <li><label for="observations">Observations: <span id="observations"></span>
					<div class="popup" onclick="observationsPopUpAnimation()"> ?
                        <span class="popuptext" id="myPopup">You can allow your customers to know if your restaurant has: wi-fi, takeAway, live music, vegan menu options, wheelchair access, bar, etc.</span>
                    </div><br></label></li>
                    <li><label for="owner">Owner: <span id="owner"></span></label></li>
                </ul>
            </div>
        </li>
        
        <div id = "menu">
			<h2>Menu</h2>
         </div>
        
        <div  id="reviews">
			<h2>Reviews</h2>
        </div>
       
        <div id="photos">
			<h2>Photos</h2>
        </div>
       
	</section>
</section>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"> <!-- para css das estrelas -->

<section id="newReview">
</section>
</section>
<script language="JavaScript">
	$(document).ready(getInfo());
</script>