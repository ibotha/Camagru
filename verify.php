<?php
	require 'config/setup.php';
	$sql = "SELECT * FROM `users` WHERE verif = :verif LIMIT 1";
	$users_req = $conn->prepare($sql);
	$users_req->bindParam(":verif", $_GET['key']);
	$users_req->execute();
	$row = $users_req->fetch(PDO::FETCH_ASSOC);
	$activate = "UPDATE users SET `active` = 1 WHERE verif = :verif LIMIT 1;";
	$act = $conn->prepare($activate);
	$act->bindParam(":verif", $_GET['key']);
	if ($row['active'] == 0)
		$act->execute();
	if ($row['active'] == 1)
		echo $row['username'];
		
?>