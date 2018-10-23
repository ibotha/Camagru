var video, image;

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
        image.style.height    = parseInt( image.offsetWidth * tempScale );
        image.width        = image.offsetWidth;
        image.height        = image.offsetHeight;
        var context        = image.getContext("2d"),
            scale        = image.width/temp.width;
        context.scale(scale, scale);
        context.drawImage(temp, 0, 0);
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
            document.getElementById("cancel").addEventListener("click", loadCamera);
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