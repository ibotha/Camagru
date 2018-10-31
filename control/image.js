function saveCapture()
{
	clearError();
	var imgData = document.getElementById("image").toDataURL(),
		title = document.getElementById("titleinput").value,
		xhttp = new XMLHttpRequest();
	if (!title)
	{
		displayError("Must Have A Title");
	}
	else
	{
		xhttp.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				displayError(this.responseText);
			}
			else if (this.status == 404)
				displayError("Page Not Found!");
		};
		xhttp.open("POST", "modal/saveimage.php", false);
		xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhttp.send("img=" + imgData + "&title=" + title + "&sticker=" + curSticker);
	}
	if (!isError())
		location.replace("index.php");
}

function like(likebtn, postID, userID)
{
	likebtn.style.backgroundColor = "rgba(255, 255, 255, 0.5)";
	var likes = document.querySelector("#post" + postID + " > .likes");
	likes.innerHTML = parseInt(likes.innerHTML) + 1;
	likebtn.onclick = function onclick(event)
	{
		dislike(this, postID, userID);
	};

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
			displayError(this.responseText);
		if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/like.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("post=" + postID + "&user=" + userID);
}

function dislike(likebtn, postID, userID)
{
	likebtn.style.backgroundColor = "transparent";
	var likes = document.querySelector("#post" + postID + " > .likes");
	likes.innerHTML = parseInt(likes.innerHTML) - 1;
	likebtn.onclick = function onclick(event)
	{
		like(this, postID, userID);
	};

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/dislike.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("post=" + postID + "&user=" + userID);
}

function deleteimage(id)
{
	var posts = document.getElementsByClassName("post");
	for (var i = 0; i < posts.length; i++)
	{
		if (posts[i].getAttribute('id') == id)
			posts[i].style.display = 'none';
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/deleteimage.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("id=" + id);
}