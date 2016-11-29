/**
 * Created by Andreia on 26/11/2016.
 * TODO: Remember me button
 * validUsername -> e preciso ir buscar a bd
 * validBirthdate => se esta direita e se e > 18 anos
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
	
	//if(!(validPassword(password)&& validName(name) && validEmail(email) && validPostCode(postCode)))
		//return false;

    var tmp = {'username': username, 'name': name, 'email': email, 'birthdate': birthdate, 'postCode': postCode, 'password': password, 'profilePic': profilePic};
    $.post("./database/insertUser.php", tmp, submited);
	  alert('submeti');
}

function submited(data)
{
  alert('submited');
}

function validName(name)
{
	if(name == "")
	{
		alert("Name field is required");
		return false;
	}
	return true;
}

function validEmail(email)
{
	if(!(email.includes('@') && email.includes('.')) || (email == ""))
	{
		alert("Email field is required");
		return false;
	}
	return true;
}

function validPostCode(postCode)
{
	if(postCode.length != 8)
	{
		alert("Invalid PostCode");
		return false;
	}
	
	var first = str.substring(0, 4);
	var second = str.substring(5, 8);
	
	if(first.isNaN() || second.isNaN())
	{
		alert("Invalid PostCode");
		return false;
	}
	return true;
}

function validUsername(username) // ir buscar todos os da base de dados -> ver se nao existe ou se nao ha ""
{
	return true;
}

function validPassword(password)
{
	if(password == "") 
	{
		alert("Password field required");
		return false;
	}
	
	if(password != $("input[name=confirmPassword]").val())
	{
		alert("'Password' field not coincident with 'Confirm password' field");
		return false;
	}
	
	return true;
}