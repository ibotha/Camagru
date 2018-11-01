var curOffset, imgNo, curSticker;

function loadPosts(offset, amount)
{
	curOffset = offset + amount;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		document.getElementById("loading").innerHTML = "Loading...";
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("loading").innerHTML = "";
			document.getElementById("posts").innerHTML += this.responseText;
			if (imgNo <= curOffset)
				document.getElementById("more").style.display = 'none';
			else
				document.getElementById("more").style.display = 'initial';
		}
		else if (this.status == 404)
			displayError("Page Not Found!");
	};
	xhttp.open("POST", "modal/getimage.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("offset=" + offset + "&amount=" + amount);
}

function loadMore()
{
	loadPosts(curOffset, 5);
}

function selectSticker(id)
{
	id = id.toString();
	document.getElementById("post").className = "";
	document.getElementById("post").addEventListener("click", saveCapture);
	document.getElementById("sticker").width = video.offsetWidth;
	document.getElementById("sticker").height = video.offsetHeight;
	if (curSticker)
		curSticker += ":" + id;
	else
		curSticker = id;
	cleanCurSticker();
	stickers = document.querySelectorAll(".sticker");
	for (var i = 0; i < stickers.length; i++)
	{
		if (stickers[i].getAttribute("id") == id)
		{
			stickers[i].onclick = function onclick(event)
			{
				deselectSticker(id);
			};
			stickers[i].style.backgroundColor = "rgba(255, 255, 255, 0.2)";
		}
	}
	if (curSticker)
		loadSticker(curSticker);
	else
		loadSticker('-1');
}

function cleanCurSticker()
{
	var ret, stick = curSticker.split(":")
	for (var i = 0; i < stick.length; i++)
	{
		var go = 1;
		if (!stick[i].includes("!"))
		{
			for (var j = 0; j < stick.length; j++)
			{
				if (stick[j] == (stick[i] + "!"))
				{
					go = 0;
					break;
				}
				if (j < i && stick[i] == stick[j])
				{
					go = 0;
					break;
				}
			}
		}
		else go = 0;
		if (go == 1)
		{
			if (ret)
				ret += ":" + stick[i];
			else
				ret = stick[i];
		}
	}
	curSticker = ret;
}

function deselectSticker(id)
{
	id = id.toString();
	document.getElementById("sticker").width = video.offsetWidth;
	document.getElementById("sticker").height = video.offsetHeight;
	curSticker += ":" + id + "!";
	cleanCurSticker();
	stickers = document.querySelectorAll(".sticker");
	for (var i = 0; i < stickers.length; i++)
	{
		if (stickers[i].getAttribute("id") == id)
		{
			stickers[i].onclick = function onclick(event)
			{
				selectSticker(id);
			};
			stickers[i].style.backgroundColor = "transparent";
		}
	}
	if (curSticker)
	{
		loadSticker(curSticker);
	}
	else
	{
		loadSticker('-1');
		document.getElementById("post").removeEventListener("click", saveCapture);
		document.getElementById("post").className = "greyed";
	}
}