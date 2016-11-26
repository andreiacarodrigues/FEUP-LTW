/**
 * Created by Andreia on 26/11/2016.
 */

$(document).ready(setUp);

// Initial setup
function setUp() {
    $("form").submit(submitUser);
}

// Send message
function submitUser(Event) {

    var name = $("input[name=name]").val();
    var email = $("input[name=email]").val();
    var birthdate = $("input[name=birthdate]").val();
    var postCode = $("input[name=postCode1]").val() + "-" + $("input[name=postCode2]").val();
    var username = $("input[name=username]").val();
    var password = $("input[name=password]").val();
    var profilePic = $("input[name=profilePic]").val();
    if(profilePic == "")
        profilePic = "NULL";

    var tmp = {'username': username, 'name': name, 'email': email, 'birthdate': birthdate, 'postCode': postCode, 'password': password, 'profilePic': profilePic};

  $.post("insertUser.php", tmp);
}
