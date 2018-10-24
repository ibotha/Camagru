<?php
	require 'config/setup.php';
	$sql = "SELECT * FROM `users` WHERE email = :email OR username = :username LIMIT 1";
	$users_req = $conn->prepare($sql);
	$_GET['key'];
?>