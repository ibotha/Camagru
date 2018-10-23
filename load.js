var video, image;

function runcam(){
    video = document.getElementById('webcam');
    image = document.getElementById("image").getContext("2d");

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
    image.width = video.offsetWidth;
    image.height = video.offsetHeight;
    console.log(video.height + ",  " + video.width + ",  " + image.width + ",  " + image.height);
    image.drawImage(video, 0, 0, video.width, video.height);
    document.getElementById("webcam").style.display = "none";
    document.getElementById("capture").style.display = "none";
}

function loadCamera()
{
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            document.getElementById("body").innerHTML = this.responseText;
            runcam();
            document.getElementById("capture").addEventListener("click", imagething);
            document.getElementById("image").style.display = "none";
            document.getElementById("camoptions").style.display = "none";
        }
    };

    xhttp.open("GET", "camera.php", true);
    xhttp.send();
}

function loadFeed()
{    
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            document.getElementById("body").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET", "feed.php", true);
    xhttp.send();
}

window.onload = function ()
{
    loadCamera();
    document.getElementById("Gallery").addEventListener("click", loadFeed);
    document.getElementById("home").addEventListener("click", loadCamera);
};