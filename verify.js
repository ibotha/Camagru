var pagestate;

pagestate = "verify";
var xhttp = new XMLHttpRequest();

xhttp.onreadystatechange = function()
{
	if (this.readyState == 4 && this.status == 200)
	{
		document.getElementById("body").innerHTML = this.responseText;
	}
};
xhttp.open("POST", "verify.php", true);
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.send("key=" + document.getElementById('keyholder').innerHTML);