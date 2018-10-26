<?php
	require 'config/setup.php';
	echo '<p class="big">';
	$sql = "SELECT * FROM `users` WHERE verif = :verif LIMIT 1";
	$users_req = $conn->prepare($sql);
	$users_req->bindParam(":verif", $_POST['key']);
	$users_req->execute();
	$row = $users_req->fetch(PDO::FETCH_ASSOC);
	if ($row)
	{
		$activate = "UPDATE users SET `active` = 1 WHERE verif = :verif LIMIT 1;";
		$act = $conn->prepare($activate);
		$act->bindParam(":verif", $_POST['key']);
		$act->execute();
		echo 'Account Verified!';
	}
	else
	{
		echo 'Invalid Verification key';
	}
	echo '</p>';
?>