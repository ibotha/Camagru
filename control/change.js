function repasssubmit()
{
	clearError();
	var password = document.getElementById('repasswordinput').value,
		confirm = document.getElementById('reconfirminput').value,
		name = document.getElementById('renameinput').value;
	
	var xhttp = new XMLHttpRequest();
	if (password == confirm)
	{
		if (this.readyState == 4 && this.status == 200)
		{
			xhttp.onreadystatechange = function ()
			{
				displayError(this.responseText);
			};
			xhttp.open("POST", "modal/updateuser.php", false);
			xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhttp.send("name=" + name + "&update=" + password + "&toupdate=password");
			if (!isError())
				location.replace("index.php");
		}
		else if (this.status == 404)
			displayError("Page Not Found!");
	}
	else displayError("Passwords Do Not Match");
}

function showUpdate()
{
	if (document.getElementById('updatecontainer').style.display == 'block')
		document.getElementById('updatecontainer').style.display = 'none';
	else
		document.getElementById('updatecontainer').style.display = 'block';
}

function showUpdateFields(which)
{
	document.getElementById("usernameUpdate").style.display = 'none';
	document.getElementById("emailUpdate").style.display = 'none';
	document.getElementById("passwordUpdate").style.display = 'none';
	switch (which)
	{
		case 'username':
			document.getElementById("usernameUpdate").style.display = 'block';
			break;
		case 'email':
			document.getElementById("emailUpdate").style.display = 'block';
			break;
		case 'password':
			document.getElementById("passwordUpdate").style.display = 'block';
			break;
		default:
			break;
	}
}

function updatePart(which, name)
{
	clearError();
	var password = document.getElementById('uppassword').value,
		confirm = document.getElementById('upconfirm').value,
		oldpassword = document.getElementById('upoldpassword').value,
		email = document.getElementById('upemail').value,
		username = document.getElementById('upusername').value;
	console.log(password + " " + confirm + " " + oldpassword + "::" + email + ";;" + username + "==" + which + "\\\\" + name);
	/*switch (which)
	{
		case 'username':
			var xhttp = new XMLHttpRequest();
			if (this.readyState == 4 && this.status == 200)
			{
				xhttp.onreadystatechange = function ()
				{
					displayError(this.responseText);
				};
				xhttp.open("POST", "modal/updateuser.php", false);
				xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhttp.send("name=" + name + "&update=" + username + "&toupdate=username");
				if (!isError())
					location.replace("index.php");
			}
			else if (this.status == 404)
				displayError("Page Not Found!");
			break;
		case 'email':
			var xhttp = new XMLHttpRequest();
			if (this.readyState == 4 && this.status == 200)
			{
				xhttp.onreadystatechange = function ()
				{
					displayError(this.responseText);
				};
				xhttp.open("POST", "modal/updateuser.php", false);
				xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhttp.send("name=" + name + "&update=" + password + "&toupdate=password");
				if (!isError())
					location.replace("index.php");
			}
			else if (this.status == 404)
				displayError("Page Not Found!");
			break;
		case 'password':
			var xhttp = new XMLHttpRequest();
			if (this.readyState == 4 && this.status == 200)
			{
				xhttp.onreadystatechange = function ()
				{
					displayError(this.responseText);
				};
				xhttp.open("POST", "modal/updateuser.php", false);
				xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhttp.send("name=" + name + "&update=" + password + "&toupdate=password");
				if (!isError())
					location.replace("index.php");
			}
			else if (this.status == 404)
				displayError("Page Not Found!");
			break;
		default:
			break;
	}*/
}