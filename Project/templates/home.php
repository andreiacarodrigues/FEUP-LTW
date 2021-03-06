<script language="JavaScript">

    function searchPostCode()
    {
        var status = _("pc_status");
        var search = $('#searchPost').val();

        if(is_postCode(search) || is_text(search))
        {
            status.innerHTML ="";
            window.location =  "restaurantSearch.php?search=" + search + "&mode=1";
        }
        else
            status.innerHTML = 'The searched post code/location is not valid. It should contain 4 digits followed or not by 3 other digits or only contain characters and digits.';
    }

    function searchRestaurantName()
    {
        var status = _("rn_status");
        var search = $('#searchName').val();

        if(is_name(search))
        {
            status.innerHTML ="";

            if(search != "")
                window.location =  "restaurantSearch.php?search=" + search + "&mode=0";
            else
                status.innerHTML = 'The searched name is not valid. It should only contain characters and whitespace characters.';
        }
        else
            status.innerHTML = 'The searched name is not valid. It should only contain characters and whitespace characters.';
    }

</script>

<section id="sectionBody">
    <div class="homeform">
        <p class="searchFormTitle">Search by Post Code/Location:</p>
        <div class="field">
            <input type="text" id="searchPost" placeholder="Post Code Search">
            <input type="button" value="Search" onclick="searchPostCode();">
        </div>
		 <p id="pc_status" style="font:0.9em 'Montserrat Alternates'; color:red; text-align:center;"> </p>
    </div>
    <div class="homeform">
        <p class="searchFormTitle">Search by Restaurant Name:</p>
        <div class="field">
            <input type="text" id="searchName" placeholder="Restaurant Name Search" >
            <input type="button" value="Search" onclick="searchRestaurantName();">
        </div>
		<p id="rn_status" style="font:0.9em 'Montserrat Alternates'; color:red; text-align:center;"> </p>
    </div>
</section>
