<!DOCTYPE html>
<html>
    <head>
        <title>Camagaru</title>
        <link rel="stylesheet" href="home.css" type="text/css">
        <script src="load.js" type="text/javascript"></script>
    </head>
    
    <body>
        <div id="header">
            <button id="home">Camagaru</button>
            <div id="userauth">
                <button id="Gallery">Gallery</button>
                <?php
                    if ($_SESSION['login'])
                        echo '  <button id="logout">Logout</button>
                                <button id="profile">profile</button>';
                    else
                        echo '  <button id="login">Login</button>
                                <button id="signin">Sign in</button>';
                ?>
            </div>
        </div>
        <div id=body></div>
        <div id="footer">
            <div style="margin-right: 50px">&copy;ibotha 2018</div>
        </div>
    </body>
</html>