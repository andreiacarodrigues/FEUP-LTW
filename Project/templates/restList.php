<?php
if ((isset ( $_GET ["search"] )) && (isset ( $_GET ["mode"] )))
{
    $search = trim(strip_tags($_GET["search"]));
    $mode = trim(strip_tags($_GET["mode"]));

    if(($mode != 0)&&($mode!= 1))
    {
        echo "ACCESS DENIED : you can't acess this page";
        die();
    }
    if(((!preg_match("#^(\d{4}$)|(\d{4}-\d{3}$)#",$search))&&(!preg_match("#([a-fA-F\s])*#",$search)))||($search ==""))
    {
        echo "ACCESS DENIED : you can't acess this page";
        die();
    }
}
else
{
    echo "ACCESS DENIED : you can't acess this page";
    die();
}

?>

<script language="JavaScript">

    var search = <?php echo json_encode($search) ?>;
    var mode = <?php echo json_encode($mode) ?>;

    function getRestaurants()
    {
        var stats = _("stats");

        $.get('./database/getRestaurants.php',  {search: search , mode: mode}, function(data)
            {
                var restaurants = new String(data);
                restaurants = restaurants.trim();

                if(restaurants == "No restaurants match the search.")
                     stats.innerHTML = "No restaurants match the search.";
                else
                {
                    restaurants = eval("(" + data + ")");
                    stats.innerHTML = "Total of restaurants found matching the search \"" + search + "\": " + restaurants.length + ".";

                    for(var i = 0; i < restaurants.length; i++)
                    {
                        var restaurant = restaurants[i];
                        console.log(".!" + restaurant);

                        getInfo(restaurant, i);
                    }
                }
            }
        );
    }

    function getInfo(restaurant, i)
    {
        $.get('./database/restaurantInfo.php',  {restaurant: restaurant}, function(data)
        {
            console.log(restaurant);
            var info = new String(data);
            info = info.trim();

            if(info == 'INVALID')
                console.log("Error getting restaurant information."); // meter span com isto
            else
            {
                info = eval("(" + data + ")");

                $('#list').append('<div class="result" id="result' +i+ '">');

                var photoId = info[8];
                console.log(photoId);
                if(photoId != null)
                    getPhoto(parseInt(photoId), false, '#result' + i, '#menu', './css/images_small/');
                else
                    $('#result' + i).append('<img src="./css/images_small/1.jpg" alt="Photo that represents the restaurant">');

                $('#result' + i).append('<br><a href="./restaurantProfile.php?restaurant='+ restaurant +'">' + restaurant + '</a><br>');

                if(info[9]== 0 ||info[10] == 0)
                    var rating = 0;
                else
                    var rating = Math.round((parseFloat(info[9]) / parseFloat(info[10])) * 100) / 100;

                var location = info[2];
                var avgPrice = info[4];
                var schedule = info[5];


                $('#result' + i).append('<ul>\n<li><label for="rating">Rating: <span id="rating">' +rating+ ' &#11088</span></label></li>' +
                    '<li><label for="loca">Location: <span id="loca">' +location+ '</span></label></li>' +
                    '<li><label for="avgPrice">Average Price/Person: <span id="avgPrice">' +avgPrice+ '</span></label></li>' +
                    '<li><label for="schedule">Schedule: <span id="schedule">' +schedule+ '</span></label></li>\n</ul>');
                $('#list').append('</div>');
            }
        });
    }

</script>

<section id="sectionBody">
<section class="searchResults">
    <p id="stats"> </p>
    <div id="list"> </div>
</section>
</section>

<script language="JavaScript">
    $(document).ready(getRestaurants());
</script>