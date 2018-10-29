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
<h1><?php print_r($row['username']); ?><h1>
<div class="options" id="profile options" <?php if ($row['username'] != $_SESSION['login']) echo "style='display: none'";?>>
	<button id="modify">Modify Account</button>
</div>