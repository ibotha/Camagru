function repasssubmit()
{
	clearError();
	var password = document.getElementById('repasswordinput').value,
		confirm = document.getElementById('reconfirminput').value,
		verif = document.getElementById('reverifinput').value;
		console.log(verif);
	
	var xhttp = new XMLHttpRequest();
	if (password == confirm)
	{
			xhttp.onreadystatechange = function ()
			{
				if (this.readyState == 4 && this.status == 200)
				{
					displayError(this.responseText);
					if (!isError())
						location.replace("index.php");
				}
				else if (this.status == 404)
					displayError("Page Not Found!");
			};
			xhttp.open("POST", "modal/updateuser.php");
			xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhttp.send("key=" + escape(verif) + "&update=" + escape(password) + "&toupdate=repassword");
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
	switch (which)
	{
		case 'username':
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function ()
			{
				if (this.readyState == 4 && this.status == 200)
				{
					displayError(this.responseText);
					if (!isError())
						location.replace("index.php");
				}
				else if (this.status == 404)
					displayError("Page Not Found!");
			};
			xhttp.open("POST", "modal/updateuser.php");
			xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhttp.send("name=" + escape(name) + "&update=" + escape(username) + "&toupdate=username");
			break;
		case 'email':
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function ()
			{
				if (this.readyState == 4 && this.status == 200)
				{
					displayError(this.responseText);
					if (!isError())
						location.replace("index.php");
				}
				else if (this.status == 404)
					displayError("Page Not Found!");	
			};
			xhttp.open("POST", "modal/updateuser.php");
			xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhttp.send("name=" + escape(name) + "&update=" + escape(email) + "&toupdate=email");
			break;
		case 'password':
			if (password == confirm)
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function ()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						displayError(this.responseText);
						if (!isError())
							location.replace("index.php");
					}
					else if (this.status == 404)
						displayError("Page Not Found!");
				};
				xhttp.open("POST", "modal/updateuser.php");
				xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhttp.send("name=" + escape(name) + "&update=" + escape(password) + "&toupdate=password" + "&oldpassword=" + escape(oldpassword));
			}
			else displayError("Passwords do not match");
			break;
		default:
			break;
	}
}

function changeNotify(e)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
			displayError(this.responseText);
		if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/changeNotify.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("note=" + escape(e));
}