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
	document.getElementById("camoptions").style.display = "block";
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

function logimage(e)
{
	let file = null;

	for (let i = 0; i < e.length; i++) {
		if (e[i].type.match(/^image\//)) {
		file = e[i];
		break;
		}
	}

	if (file !== null) {
		document.getElementById("image").style.display = "block";
		document.getElementById("camoptions").style.display = "block";

		var img = new Image, context = image.getContext('2d');
		img.onload = function ()
		{
			image.width = this.width;
			image.height = this.height;
			context.drawImage(img, 0, 0);
			console.log(this.width + " " + this.height);
		}

		img.src = URL.createObjectURL(file);

		document.getElementById("webcam").style.display = "none";
		document.getElementById("capture").style.display = "none";
		document.getElementById("upload").style.display = "none";
	}
}

function loadCamera()
{
	curSticker = "";
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
			if (this.responseText == "<H1>Must Log In</H1>")
			{
				showLogin();
			}
			else
			{
				runcam();
				document.getElementById("capture").addEventListener("click", imagething);
				document.getElementById("cancel").addEventListener("click", loadCamera);
				document.getElementById("image").style.display = "none";
				document.getElementById("camoptions").style.display = "none";
				loadStickers();
				document.getElementById("uploadinput").addEventListener('change', (e) => logimage(e.target.files));
			}
		}
	};
	xhttp.open("GET", "view/camera.php");
	xhttp.send();
	pagestate = "camera";
}

function loadFeed()
{
	if (pagestate == 'verify')
	{
		location.replace('index.php');
	}
	var xhttp2 = new XMLHttpRequest();

	xhttp2.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("body").innerHTML = this.responseText;
			loadPosts(0, 5);
			document.getElementById("more").addEventListener("click", loadMore)
		}
	};

	xhttp2.open("GET", "view/feed.php", true);
	xhttp2.send();
	pagestate = 'feed';
}

function loadStickers()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		document.getElementById("stickers").innerHTML = 'LOADING STICKERS...';
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("stickers").innerHTML = this.responseText;
		}
		else if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/getsticker.php");
	xhttp.send();
}

function loadSticker(id)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("sticker").innerHTML = this.responseText;
			var sticks = document.getElementsByClassName("stick")
			for (var i = 0; i < sticks.length; i++)
				sticks[i].width = 200;
		}
		else if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/getsticker.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("id=" + escape(id));
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
			document.getElementById("notifications").addEventListener('change', (e) => changeNotify(e.target.checked));
		}
		else if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "view/profile.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("username=" + escape(this.innerHTML));
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
	document.getElementById("password").style.display = "block";
	document.getElementById("email").style.display = "block";
	document.getElementById("username").style.display = "none";
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
	document.getElementById("resend").style.display = "block";
	userstate = "signup";
}

function showForgot()
{
	hide();
	document.getElementById("email").style.display = "block";
	document.getElementById("submit").style.display = "block";
	userstate = "forgot";
}

function showResend()
{
	hide();
	document.getElementById("email").style.display = "block";
	document.getElementById("submit").style.display = "block";
	userstate = "resend";
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

function login(email, password)
{
	var xhttp = new XMLHttpRequest();


	xhttp.onreadystatechange = function ()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			if (this.responseText.length > 1)
			{
				displayError(this.responseText);
			}
			else
				location.replace('index.php');
		}
		else if (this.status == 404)
			displayError("Page not found");
	};

	xhttp.open("POST", "modal/signup.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("email=" + escape(email) + "&password=" + escape(password) + "&state=login");
}

function forgot(email)
{
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function ()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			if (this.responseText.length > 1)
			{
				displayError(this.responseText);
			}
			else
				hide();
		}
		else if (this.status == 404)
			displayError("Page not found");
	};

	xhttp.open("POST", "modal/signup.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("email=" + escape(email) + "&state=forgot");
}

function resend(email)
{
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function ()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			if (this.responseText.length > 1)
			{
				displayError(this.responseText);
			}
			else
				hide();
		}
		else if (this.status == 404)
			displayError("Page not found");
	};

	xhttp.open("POST", "modal/signup.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("email=" + escape(email) + "&state=resend");
}

function signup(username, email, password)
{
	var xhttp = new XMLHttpRequest();


	xhttp.onreadystatechange = function ()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			if (this.responseText.length > 1)
			{
				displayError(this.responseText);
			}
			else
				hide();
		}
		else if (this.status == 404)
			displayError("Page not found");
	};

	xhttp.open("POST", "modal/signup.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("username=" + escape(username) + "&email=" + escape(email) + "&password=" + escape(password) + "&state=signup");
}

function logout()
{
	var xhttp = new XMLHttpRequest();


	xhttp.onreadystatechange = function ()
	{
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
	document.getElementById("forgot").style.display = "none";
	document.getElementById("resend").style.display = "none";
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
		if (password != confirm)
		{
			displayError("Passwords Don't match");
			return;
		}
		signup(username, email, password);
	}
	if (userstate == "login")
	{
		if ((!email || !password))
		{
			displayError("All Fields Required");
			return;
		}
		login(email, password);
	}
	if (userstate == "forgot")
	{
		if (!email)
		{
			displayError("All Fields Required");
			return;
		}
		forgot(email);
	}
	if (userstate == "resend")
	{
		if (!email)
		{
			displayError("All Fields Required");
			return;
		}
		resend(email);
	}
}

window.onload = function ()
{
	var xhttp1 = new XMLHttpRequest();
	xhttp1.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			imgNo = parseInt(this.responseText);
		}
		else if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp1.open("GET", "modal/getimagecount.php", true);
	xhttp1.send();

	if (pagestate != "verify")
		loadFeed();
	document.getElementById("Gallery").addEventListener("click", loadFeed);
	document.getElementById("home").addEventListener("click", loadCamera);
	document.getElementById("profile").addEventListener("click", loadProfile);
	document.getElementById("login").addEventListener("click", showLogin);
	document.getElementById("logout").addEventListener("click", logout);
	document.getElementById("signup").addEventListener("click", showSignup);
	document.getElementById("submit").addEventListener("click", submit);
	document.getElementById("forgot").addEventListener("click", showForgot);
	document.getElementById("resend").addEventListener("click", showResend);
	document.getElementById("error").addEventListener("click", clearError);
};

function comment(id)
{
	var posts = document.getElementsByClassName("commentbox");
	for (var i = 0; i < posts.length; i++)
	{
		if (posts[i].getAttribute('id') == id)
		{
			var ret = posts[i].value;
			ret = ret.trim();
			posts[i].value = "";
		}
	}
	if (!ret.length)
	{
		return;
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
			displayError(this.responseText);
		if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/comment.php");
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("content=" + escape(ret) + "&post=" + escape(id));
	document.getElementById("com" + id).innerHTML += '<div class=comment>' +
	'<div class="commentuploader" style="color:white;">Me: &nbsp; </div>' +
	'<div class="com">' +
		ret.replace(/</g, "&lt;") +
	'</div>' +
	'</div>';
}
