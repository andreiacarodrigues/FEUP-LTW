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
                _("description").innerHTML = info[1];
                _("location").innerHTML = info[2];
                _("contact").innerHTML = info[3];
                _("avgPrice").innerHTML = info[4];
                _("schedule").innerHTML = info[5];
				_("observations").innerHTML = info[6];
				
				var menuId = info[7];
				var photoId = info[8];
	
				if(photoId != null)
					getPhoto(parseInt(photoId), false, '#main', '#menu', './css/Images/');
				else
					$('#main').prepend('<img src="./css/Images/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
				
				if(menuId != null)
					getPhoto(parseInt(menuId) , true, '#main', '#menu', './css/Images/');
				else
					$('#menu').html('<img src="./css/Images/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
				
				var rating_sum = info[9];
				var rating_total = info[10];
				var rating = Math.round((parseFloat(rating_sum) / parseFloat(rating_total)) * 100) / 100
                _("rating").innerHTML = rating; 
             
				var owner = info[11];
			    _("owner").innerHTML = owner;
			   
			    if(username == owner)
			    	$('#options').html('<li><a href="restaurantProfileEdit.php?restaurant=' + restaurant +'">Edit</a></li>');
			    else
					$('#options').html('<li><a href="#newReview">Leave Review</a></li>');
				
				getReviews(owner);
				getPhotos();
				
				if(owner != username)
					showNewReview();
						   
			   return true;
            }
        };

        xmlhttp.open("GET","database/RestaurantInfo.php?restaurant="+ restaurant,true);
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
					$.get('./templates/review.php',  {info: info[i], owner: owner , username: username}, function(data) 
					{
						$('#reviews').append(data);
					}
					);
				}
				return true;	
            }
        };

        xmlhttp.open("GET","database/RestaurantReviews.php?restaurant="+ restaurant,true);
        xmlhttp.send();
	}
	
	function getPhotos()
	{
		$.get('./database/RestaurantPhotos.php',  {restaurant: restaurant}, function(data) 
		{
					
			if(data != "INVALID")
			{
				var photos = eval("(" + data + ")"); 
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
			
			xmlhttp.open("GET","database/AddReply.php?id="+r + "&username="+u+"&text="+t,true);
			xmlhttp.send();

		}
	}
	
	function radioListCheck(name) 
	{
		for (var x = 5; x >= 1; x--) { // 5 é o maior rating
			if (document.getElementById(name + '-' + x).checked) {
				return 6-x; // don't know why mas não me dá o valor certo de outra maneira
			}
		}
		return -1;
	}

	function submitReview()
	{
		var u = username;
		var res = restaurant;
		var t = _("review").value;
		var pics = _("reviewPic").value; 
		var rat = radioListCheck("star");
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var date = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day;
		
		var r_status = _("r_status");
	
		if(rat == -1)
			r_status.innerHTML = "You need at least to leave a rating if you want to submit a review.";
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
					$('#review').val('');
				}
			};
			
			xmlhttp.open("GET","database/AddReview.php?username="+u+"&restaurant="+res+"&rating="+rat+"&text="+t+"&date="+date+"&pics="+pics,true);
			xmlhttp.send();

		}
	}
		
   function showNewReview()
   {
		$.get('./templates/newReview.php', function(data) 
		{
			$('#newReview').append(data);
		}
		);
   }

</script>

<section id="main" >
    <h2 id="name">Restaurant Name</h2>  
    <h3 id="rating">Rating</h3>            
    <div id ="options"> </div>
</section>
<section id="Details">
    <ul id="tabs">
        <li id="informations">
            <a href="#">Informations</a>
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
            </div>
        </li>
        <li>
            <a href="#photos">Fotos</a>
            <div id="photos">
            </div>
        </li>
    </ul>
</section>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"> <!-- para css das estrelas -->

<section id="newReview">
</section>

<script language="JavaScript">
$(document).ready(getInfo());
</script>