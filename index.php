<!DOCTYPE html>
<?php
	session_start();
?>
<html>
	<head>
		<title>Camagaru</title>
		<link rel="stylesheet" href="view/styles/home.css" type="text/css">
		<script src="control/load.js" type="text/javascript"></script>
		<script src="control/change.js" type="text/javascript"></script>
	</head>
	
	<body>
		<div id="header">
			<button id="home">Camagaru</button>
			<div id="userauth">
				<button id="Gallery">Gallery</button>
				<button id="login">Login</button>
				<button id="signup">Sign Up</button>
				<button id="logout" style="display: none;">Logout</button>
				<button id="profile" style="display: none;"><?php echo $_SESSION['login']; ?></button>
				<?php
					if ($_SESSION['login'])
					{ ?>
						<script>
							document.getElementById("login").style.display = 'none';
							document.getElementById("logout").style.display = 'initial';
							document.getElementById("profile").style.display = 'initial';
							document.getElementById("signup").style.display = 'none';
						</script>
				<?php } ?>
			</div>
			<div id="logindd">
				<div class="field" id="error">
					<p id="message"></p>
				</div>
				<div class="field" id="username">
					<input id="usernameinput" placeholder="Username">
				</div>
				<div class="field" id="email">
					<input id="emailinput" type="email" placeholder="Email">
				</div>
				<div class="field" id="password">
					<input id="passwordinput" type="password" placeholder="Password">
				</div>
				<div class="field" id="confirm">
					<input id="confirminput" type="password" placeholder="Confirm Password">
				</div>
				<button id="submit">OK</button>
				<button id="forgot">Forgot Password?</button>
			</div>
		</div>
		<div id=body></div>
		<?php if($_GET["key"]){ echo '<div id="keyholder" style="display: none;">'.$_GET["key"].'</div><script src="control/verify.js" type="text/javascript"></script>';}
				if($_GET["forgot"]){ echo '<div id="forgotholder" style="display: none;">'.$_GET["forgot"].'</div><script src="control/verify.js" type="text/javascript"></script>';} ?>
		<div id="footer">
			<div style="margin-right: 50px">&copy;ibotha 2018</div>
		</div>
	</body>
</html>