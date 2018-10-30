var video, image, userstate, pagestate;

function runcam(){
	video = document.getElementById('webcam');
	image = document.getElementById("image");

	if (navigator.mediaDevices.getUserMedia)
	{
		navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream)
		{
			video.srcObject = stream;
		})
		.catch(function(errOr) 
		{
			console.log(errOr);
		});
	}
}

function imagething()
{
	document.getElementById("image").style.display = "block";
	document.getElementById("camoptions").style.display = "flex";
	var temp = document.createElement('canvas');

		temp.width  = video.offsetWidth;
		temp.height = video.offsetHeight;

		var tempcontext = temp.getContext("2d"),
			tempScale = (temp.height/temp.width);

		tempcontext.drawImage(
			video,
			0, 0,
			video.offsetWidth, video.offsetHeight
		);
		image.style.height = parseInt(image.offsetWidth * tempScale);
		image.width = video.offsetWidth;
		image.height = video.offsetHeight;
		var context = image.getContext("2d"),
			scale = image.width/temp.width;
		context.scale(scale, scale);
		context.drawImage(temp, 0, 0);
	document.getElementById("webcam").style.display = "none";
	document.getElementById("capture").style.display = "none";
	document.getElementById("upload").style.display = "none";
}

function loadCamera()
{
	if (pagestate == 'verify')
	{
		location.replace('index.php');
	}
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("body").innerHTML = this.responseText;

			runcam();
			document.getElementById("capture").addEventListener("click", imagething);
			document.getElementById("cancel").addEventListener("click", loadCamera);
			document.getElementById("image").style.display = "none";
			document.getElementById("camoptions").style.display = "none";
		}
	};
	xhttp.open("GET", "view/camera.php", true);
	xhttp.send();
	pagestate = "camera";
}

function loadFeed()
{
	if (pagestate == 'verify')
	{
		location.replace('index.php');
	}
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("body").innerHTML = this.responseText;
		}
	};

	xhttp.open("GET", "view/feed.php", true);
	xhttp.send();
	pagestate = 'feed';
}

function loadProfile()
{
	if (pagestate == 'verify')
		window.location = 'index.php';
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("body").innerHTML = this.responseText;
		}
	};
	xhttp.open("POST", "view/profile.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("username=" + this.innerHTML);
	pagestate = "profile";
}

function showLogin()
{
	if (userstate == "login")
	{
		hide();
		return;
	}
	hide();
	document.getElementById("username").style.display = "block";
	document.getElementById("password").style.display = "block";
	document.getElementById("email").style.display = "none";
	document.getElementById("confirm").style.display = "none";
	document.getElementById("submit").style.display = "block";
	document.getElementById("forgot").style.display = "block";
	userstate = "login";
}

function showSignup()
{
	if (userstate == "signup")
	{
		hide();
		return;
	}
	hide();
	document.getElementById("username").style.display = "block";
	document.getElementById("password").style.display = "block";
	document.getElementById("confirm").style.display = "block";
	document.getElementById("email").style.display = "block";
	document.getElementById("submit").style.display = "block";
	document.getElementById("forgot").style.display = "none";
	userstate = "signup";
}

function showForgot()
{
	if (userstate == "signup")
	{
		hide();
		return;
	}
	hide();
	document.getElementById("username").style.display = "none";
	document.getElementById("password").style.display = "none";
	document.getElementById("confirm").style.display = "none";
	document.getElementById("email").style.display = "block";
	document.getElementById("submit").style.display = "block";
	document.getElementById("forgot").style.display = "none";
	userstate = "forgot";
}

function isError()
{
	if (document.getElementById("error").style.display == "none")
		return false;
	else
		return true;
}

function getPageError()
{
	return document.getElementById("error").innerHTML;
}

function clearError()
{
	document.getElementById("error").style.display = "none";
	document.getElementById("message").innerHTML = "";
}

function login(username, password)
{
	var xhttp = new XMLHttpRequest();


	xhttp.onreadystatechange = function ()
	{
		if (this.responseText.length > 1)
		{
			displayError(this.responseText);
		}
	};

	xhttp.open("POST", "modal/signup.php", false);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("username=" + username + "&email=" + email + "&password=" + password + "&state=login");
	if (!isError())
		location.replace('index.php');
}

function forgot(email)
{
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function ()
	{
		if (this.responseText.length > 1)
		{
			displayError(this.responseText);
		}
	};

	xhttp.open("POST", "modal/signup.php", false);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("email=" + email + "&state=forgot");
}

function signup(username, email, password)
{
	var xhttp = new XMLHttpRequest();


	xhttp.onreadystatechange = function ()
	{
		if (this.responseText.length > 1)
		{
			displayError(this.responseText);
		}
	};

	xhttp.open("POST", "modal/signup.php", false);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("username=" + username + "&email=" + email + "&password=" + password + "&state=signup");
}

function logout()
{
	var xhttp = new XMLHttpRequest();


	xhttp.onreadystatechange = function ()
	{
		if (this.responseText.length > 1)
		{
		}
	};

	xhttp.open("GET", "modal/logout.php", true);
	xhttp.send();
	location.reload();
}

function displayError(message)
{
	document.getElementById("message").innerHTML = message;
	if (message)
		document.getElementById("error").style.display = "block";
}

function hide()
{
	document.getElementById("username").style.display = "none";
	document.getElementById("password").style.display = "none";
	document.getElementById("confirm").style.display = "none";
	document.getElementById("email").style.display = "none";
	document.getElementById("submit").style.display = "none";
	document.getElementById("usernameinput").value = "";
	document.getElementById("passwordinput").value = "";
	document.getElementById("confirminput").value = "";
	document.getElementById("emailinput").value = "";
	userstate="";
}

function submit()
{
	clearError();
	var username = document.getElementById("usernameinput").value;
	var password = document.getElementById("passwordinput").value;
	var confirm = document.getElementById("confirminput").value;
	var email = document.getElementById("emailinput").value;
	if (userstate == "signup")
	{
		if (!username || !password || !email || !confirm)
		{
			displayError("All Fields Required");
			return;
		}
		signup(username, email, password);
		if(isError())
			return;
	}
	if (userstate == "login")
	{
		if ((!username || !password))
		{
			displayError("All Fields Required");
			return;
		}
		login(username, password);
		if(isError())
		{
			return;
		}
	}
	if (userstate == "forgot")
	{
		if (!email)
		{
			displayError("All Fields Required");
			return;
		}
		forgot(email);
		if(isError())
		{
			return;
		}
	}
	hide();
}

window.onload = function ()
{
	if (pagestate != "verify")
		loadCamera();
	document.getElementById("Gallery").addEventListener("click", loadFeed);
	document.getElementById("home").addEventListener("click", loadCamera);
	document.getElementById("profile").addEventListener("click", loadProfile);
	document.getElementById("login").addEventListener("click", showLogin);
	document.getElementById("logout").addEventListener("click", logout);
	document.getElementById("signup").addEventListener("click", showSignup);
	document.getElementById("submit").addEventListener("click", submit);
	document.getElementById("forgot").addEventListener("click", showForgot);
	document.getElementById("error").addEventListener("click", clearError);
};
