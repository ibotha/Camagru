<!DOCTYPE html>
<?php
	session_start();
	//require "config/setup.php";
?>
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
				<?php if ($_SESSION['login'])
					echo '
					<div class="field">
						<p id="message">'.$_SESSION['login'].'</p>
					</div>
					<button id="logout">Logout</button>
					<button id="profile">Profile</button>';
					else echo '
						<button id="login">Login</button>
						<button id="signup">Sign Up</button>';
				?>
			</div>
			<div id="logindd">
				<div class="field" id="error">
					<p id="message">a</p>
				</div>
				<div class="field" id="username">
					<p>Username</p>
					<input id="usernameinput">
				</div>
				<div class="field" id="email">
					<p>Email</p>
					<input id="emailinput" type="email">
				</div>
				<div class="field" id="password">
					<p>Password</p>
					<input id="passwordinput" type="password">
				</div>
				<div class="field" id="confirm">
					<p>Confirm Password</p>
					<input id="confirminput" type="password">
				</div>
				<button id="submit" type="submit">OK</button>
			</div>
		</div>
		<div id=body></div>
		<div id="footer">
			<div style="margin-right: 50px">&copy;ibotha 2018</div>
		</div>
	</body>
</html>