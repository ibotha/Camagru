<?php
session_start();
set_include_path ("../");
require 'config/setup.php';
$password = hash('whirlpool', $_POST['password']);
$users_req = $conn->prepare("SELECT * FROM `users` WHERE username = :username LIMIT 1");
$users_req->bindParam(":username", $_POST['username']);
$users_req->execute();
$row = $users_req->fetch();
?>
<h1><?php printf("%s<br/>%s", $row['username'], $row['email']); ?><h1>
<div class="options" id="profile options" <?php if ($row['username'] != $_SESSION['login']) echo "style='display: none'";?>>
	<button id="modify" onclick="showUpdate()">Modify Account</button>
</div>
<div id="updatecontainer" style="display: none;">
	<h1>Update</h1>
	<div class="options" id="update" <?php if ($row['username'] != $_SESSION['login']) echo "style='display: none'";?>>
		<div><span style="font-size: 20px;">Notifications:</span><input id="notifications" type="checkbox" <?php if($row['notify']) echo 'checked'; ?>></div>
		<button id="upname" onclick="showUpdateFields('username')">Username</button>
		<button id="upmail" onclick="showUpdateFields('email')">Email</button>
		<button id="uppwd" onclick="showUpdateFields('password')">Password</button>
	</div>
	<div id="usernameUpdate" style="display: none; width: 40%; margin: auto;">
		<div class="field" style="display: initial">
			<input id="upusername" placeholder="New Username">
		</div>
		<button onclick="updatePart('username', '<?php echo $_SESSION['login']; ?>')">OK</button>
	</div>
	<div id="emailUpdate" style="display: none; width: 40%; margin: auto;">
		<div class="field" style="display: initial">
			<input id="upemail" placeholder="New Email">
		</div>
		<button onclick="updatePart('email', '<?php echo $_SESSION['login']; ?>')">OK</button>
	</div>
	<div id="passwordUpdate" style="display: none; width: 40%; margin: auto;">
		<div class="field" style="display: initial">
			<input id="upoldpassword" type="password" placeholder="Old Password">
		</div>
		<div class="field" style="display: initial">
			<input id="uppassword" type="password" placeholder="New Password">
		</div>
		<div class="field" id="repassword" style="display: initial">
			<input id="upconfirm" type="password" placeholder="Confirm Password">
		</div>
		<button onclick="updatePart('password', '<?php echo $_SESSION['login']; ?>')">OK</button>
	</div>
</div>