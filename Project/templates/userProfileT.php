<?php
if (isset ( $_GET ["username"] )) {
    $username = trim(strip_tags($_GET["username"]));
}
else if (isset ( $_SESSION ["userid"] )) {
    $username = $_SESSION ["userid"];
}
else {
    echo 'ACCESS DENIED : you must be logged in to access this page';
    die();
}
?>

<script language="JavaScript">

    var username = <?php echo json_encode($username) ?>;
	
	<?php if(isUserLoggedIn()) { ?>
    var sessionUsername = <?php echo json_encode($_SESSION ["userid"]) ?>;
	<?php }
	else{?>
	var sessionUsername = "";
	<?php } ?>

	var tabList = ['main', 'friends', 'manageRestaurants', 'visitedPlaces', 'history'];

    function getInfo(){

		 openTab('main');

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                var info = new String(this.responseText);
                info = info.trim();

                if(info == "INVALID"){
                    return false;
                }
                else if(info == "ERROR") {
                    alert("ERROR : some variables are not defined");
                    return false;
                }
                else if(info == "USER ERROR") {
                    alert("ERROR : the user requested is no longer active");
                    document.location='index.php';
                    return false;
                }
                else
                    info = eval("(" + this.responseText + ")");

                _("username").innerHTML = username;
                _("name").innerHTML = info[0];
                _("email").innerHTML = info[1];
                _("birthdate").innerHTML = info[2];
                _("postCode").innerHTML = info[3];
				_("location").innerHTML = info[6];

                initMap(info[3] + " " + info[6]);

                var photoId = info[4];
                if(photoId != null)
                    getPhoto(parseInt(photoId), false, '#informacoes', '', small_path);
                else
                    $('#informacoes').prepend('<img src='+default_user+' alt="Photo that represents the user">');

                //qualquer pessoa pode ver as minhas reviews, os restaurantes que visitei, e os restaurantes que eu sou dono
                if(info[5])
                    getReviews(username);
                else
                    getReviews(null);

                getVisited();
                getFriends();
                getMyRestaurants();


                if((username != sessionUsername) && (sessionUsername != ""))
                {
                    $.get('./database/checkFriends.php',  {sessionUsername: sessionUsername, username: username}, function(data){
                        var info = new String(data);
                        info = info.trim();

                        if(info == "ERROR") {
                            alert("ERROR : some variables are not defined");
                            return false;
                        }
                        else if(info == "YES")
						{
							 document.getElementById("addFriend").style.display = "none";
							 document.getElementById("deleteFriend").style.display ="inline";
						}
                           
                        else
						{
							 document.getElementById("deleteFriend").style.display = "none";
							 document.getElementById("addFriend").style.display = "inline";
						}
                           

                    });
                }
            }
        };

        xmlhttp.open("GET","database/userInfo.php?username="+ username,true);
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
            if (this.readyState == 4 && this.status == 200)
            {
                var info = new String(this.responseText);
                info = info.trim();

                if(info == "INVALID"){
                    return false;
                }
                else if(info == "ERROR") {
                    alert("ERROR : some variables are not defined");
                    return false;
                }
                else
                    info = eval("(" + this.responseText + ")");

                for(var i = 0; i < info.length; i++)
                {
                    var jsonString = JSON.stringify(info[i]);
					
                    $.get('./templates/review.php',  {info: jsonString, username: username, isRestaurant: 0}, function(data)
                        {
							 var info = new String(data);
							info = info.trim();
                            $('#history').append(info);
                        }
                    );
                }
                return true;
            }
        };

        xmlhttp.open("GET","database/userReviews.php?username="+ username,true);
        xmlhttp.send();
    }

    function getVisited(){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                var info = new String(this.responseText);
                info = info.trim();

                if(info == "INVALID"){
                    return false;
                }
                else if(info == "ERROR") {
                    alert("ERROR : some variables are not defined");
                    return false;
                }
                else
                    info = eval("(" + this.responseText + ")");

                for (var i = 0; i < info.length; i++)
                {
					var name = info[i][0];
					if((info[i][1] == 0) || (info[i][4] == 0))
						var rating = 0;
					else
						var rating = (parseFloat(info[i][1]) / parseFloat(info[i][4]));
				
					rating = parseFloat(Math.round(rating * 100) / 100).toFixed(1);
	
                    $('#visitedPlaces').append('<article>\n<ul>' +
                        '\n<a href="./restaurantProfile.php?restaurant='+ name +'">'+ name+'</a><br>' +
                        '\n<li><label for="vis_rating">Rating: <span id="vis_rating">' + rating + '</span></label></li>' +
                        '\n<li><label for="vis_local">Location: <span id="vis_local">' + info[i][2] + '</span></label></li>\n');

                    var photo = info[i][3];
                    if(photo != null){
                        $('#visitedPlaces').append('<img src='+small_path+photo+' alt="Photo that represents the restaurant">');
                    }
                    else{
                        $('#visitedPlaces').append('<img src='+default_restaurant+' alt="Photo that represents the restaurant">');
                    }

                    $('#visitedPlaces').append('\n</ul>\n</article>');
                }
            }
        };

        xmlhttp.open("GET","database/userVisitedRest.php?username="+username,true);
        xmlhttp.send();
    }

    function getMyRestaurants(){

        if(username != sessionUsername)
        {
            var elements = document.getElementsByClassName("justForOwner");

            for (var i = 0; i < elements.length; i++) {
                elements[i].style.display = "none";
            }
            
            return;
        }

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                var info = new String(this.responseText);
                info = info.trim();

                if(info == "ERROR") {
                    alert("ERROR : some variables are not defined");
                    return false;
                }
                else if(info == "INVALID"){
                    $('#manageRestaurants').append ('<br><a href="addRestaurant.php">Add Restaurant');
                    return false;
                }
                else
                    info = eval("(" + this.responseText + ")");

                for (var i = 0; i < info.length; i++)
                {
					var rating_sum = info[i][1];
					var rating_total = info[i][4];
				
					if((rating_sum == 0) || (rating_total == 0))
						var rating = 0;
					else
						var rating = Math.round((parseFloat(rating_sum) / parseFloat(rating_total)) * 100) / 100;
					
                    var name = info[i][0];
                    $('#manageRestaurants').append('<article>\n<ul>' +
                        '\n<a href="./restaurantProfile.php?restaurant='+ name +'">'+ name+'</a><br>' +
                        '\n<li><label for id="my_rating">Rating: <span id="my_rating">' + rating + ' &#11088</span></label></li>' +
                        '\n<li><label for id="my_local">Location: <span id="my_local">' + info[i][2] + '</span></label></li>\n');

                    var photo = info[i][3];
                    if(photo != null){
                        $('#manageRestaurants').append('<img src='+small_path+photo+' alt="Photo that represents the restaurant">');
                    }
                    else{
                        $('#manageRestaurants').append('<img src='+default_restaurant+' alt="Photo that represents the restaurant">');
                    }

                    $('#manageRestaurants').append('\n</ul>\n</article>');
                }

                $('#manageRestaurants').append ('<br><a href="addRestaurant.php" id="buttons">Add Restaurant');
            }
        };

        xmlhttp.open("GET","database/ownerRestaurants.php?username="+username,true);
        xmlhttp.send();
    }

    function getFriends()
    {
        $.get('./database/getFriends.php',  {username: username}, function(data){
            var info = new String(data);
            info = info.trim();

            if(info == "ERROR") {
                alert("ERROR : some variables are not defined");
                return false;
            }
            else if(info == "NO FRIENDS")
                return false;
            else
            {
                info = eval("(" + info + ")");

                for(var i = 0; i < info.length; i++)
                {
                    $('#friends').append('<li><a href="./userProfile.php?username='+ info[i] +'">'+ info[i]+'</a></li>');
                }
            }
        });
    }

	

</script>

<section id="sectionBody">
	<section id="profile">
		 <section id="menuProfile" >
			<ul>
				<a href="#" onclick="openTab('main')">Informations</a>
				<br>
				<a href="#" onclick="openTab('history')">History</a>
				<br>
				<a href="#" onclick="openTab('visitedPlaces')">Visited Restaurants</a>
				<br>
				<a href="#" onclick="openTab('friends')">Following</a>
				<br>
				<a class="justForOwner" href="#" onclick="openTab('manageRestaurants')">Manage Restaurants</a>
			</ul>
		</section>

    <section id="main" >
	<h2>Informations</h2>
        <ul id="informacoes">
			<li><label for="username">Username: <span id="username"></span></label></li>
            <li><label for="name">Name: <span id="name"></span></label></li>
			<li><label for="name">Email: <span id="email"></span></label></li>
			<li><label for="name">Birthday: <span id="birthdate"></span></label></li>
			<li><label for="name">Post-Code: <span id="postCode"></span></label></li>
			<li><label for="name">Location: <span id="location"></span></label></li>
           
            <div id="addFriend"></div>
            <div id="deleteFriend"></div>
            <div id="edit"></div>
        </ul>
		<div id="map"/></div>
		
		 
        <?php
        if (isUserLoggedIn ()){   ?>
            <script language="JavaScript">

                var sessionUsername = <?php echo json_encode($_SESSION ["userid"]) ?>;

                if(username != sessionUsername)
                {
					
                    _("addFriend").innerHTML = "<a href=\"./database/addFriend.php?username="+username+"&sessionUsername=" + sessionUsername +"\">Follow</a><br>";
                    _("deleteFriend").innerHTML = "<a href=\"./database/deleteFriend.php?username="+username+"&sessionUsername=" + sessionUsername +"\">Unfollow</a><br>";
                }
                else
                {
                    _("edit").innerHTML = "<a href=\"./userProfileEdit.php?username="+username+"\">Edit Profile</a><br>"; //foto do restaurant
                }

            </script>
        <?php  }   ?>
    </section>

    <section id="dashboard" >
        <ul>
            <li id="history"><h2>History</h2></li>  <!-- conjunto das reviews feitas pelo utilizador -->
            <li id="visitedPlaces"><h2>Visited Places</h2></li>    <!-- nome dos restaurantes que foi feita uma review -->
            <li class="justForOwner" id="manageRestaurants"><h2>Manage Restaurants</h2></li>    <!-- restaurantes que pertencem ao utilizador -->
            <li id="friends"><h2>Following</h2></li>
        </ul>
    </section>
	</section>
</section>
<script language="JavaScript">
    $(document).ready(getInfo());
</script>