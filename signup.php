<?php
	require 'config/setup.php';
	$sql = "SELECT * FROM `users` WHERE email = :email OR username = :username LIMIT 1";
	$users_req = $conn->prepare($sql);
	if (!preg_match('/[^ ]{1,}@[^ ]{1,}/', $_POST['email']))
	{
		echo "Invalid Email";
	}
	else
	{
		if ($_POST['state'] == "login")
		{
			$users_req->bindParam(":email", $_POST['username']);
			$users_req->bindParam(":username", $_POST['username']);
		}
		else
		{
			$users_req->bindParam(":email", $_POST['email']);
			$users_req->bindParam(":username", $_POST['username']);
		}
		$users_req->execute();
		$users = $users_req->fetch(PDO:: FETCH_ASSOC);
		if ($users)
			echo "Username or Email Taken";
		else
		{
			$thing = 'asd';
			$add = $conn->prepare("INSERT INTO users(username, email, `password`, verif) VALUES (:username, :email, :pwd, verif)");
			$add->bindParam(":username", $_POST['username']);
			$add->bindParam(":email", $_POST['email']);
			$add->bindParam(":pwd", $_POST['password']);
			$add->execute();
		}
	}
?>