function getPhoto(id, isMenu, idPhoto, idMenu, path)
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
				
				var trimmedFilename =  filename.slice(1, -1);
				if(isMenu)
					$(idMenu).html('<img src="' + path + trimmedFilename + '"alt="Photo that represents the restaurant">');
				else
					$(idPhoto).prepend('<img src="' + path + trimmedFilename + '"alt="Photo that represents the restaurant">');
				
			   return true;
            }
        };

    xmlhttp.open("GET","database/GetPhoto.php?id="+ id,true);
    xmlhttp.send();
}