<script language="JavaScript">

    function searchPostCode()
    {
        var status = _("pc_status");
        var search = $('#searchPostCode #search').val();

        //if(/^(\d{4}$)|(\d{4}-\d{3}$)/.test(search))
        if(is_postCode(search))
        {
            status.innerHTML ="";
            window.location =  "restaurantSearch.php?search=" + search + "&mode=1";
        }
        else
            status.innerHTML = 'The searched post/zip code is not valid. It should contain 4 digits followed or not by 3 other digits.';
    }

    function searchRestaurantName()
    {
        var status = _("rn_status");
        var search = $('#searchResName #search').val();

        console.log(search);

        //if(/([a-fA-F\s])*/.test(search))
        if(is_name(search))
        {
            status.innerHTML ="";

            if(search != "")
                window.location =  "restaurantSearch.php?search=" + search + "&mode=0";
            else
                status.innerHTML = 'The searched name is not valid. It should only contain characters and whitespace characters.';
        }
        // faz o get
        else
            status.innerHTML = 'The searched name is not valid. It should only contain characters and whitespace characters.';
    }

</script>


<div class="menu">

    <form id="searchPostCode">
        <label>Search by Zip Code/Post Code:
            <input type="text" id="search" placeholder="Post Code Search">
            <input type="button" value="Search" onclick="searchPostCode();">
        </label>
    </form>
    <span id="pc_status"> </span>
    <br>
    <form id="searchResName">
        <label>Search by Resturant Name:
            <input type="text" id="search" placeholder="Restaurant Name Search" >
            <input type="button" value="Search" onclick="searchRestaurantName();">
        </label>
    </form>
    <span id="rn_status"> </span>

</div>

<!--.*([a-fA-F\s]+).*-->