<?php

set_include_path ("../");
require 'config/setup.php';
$password = hash('whirlpool', $_POST['password']);

$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
$users_req->bindParam(":username", $_POST['name']);
$users_req->execute();
$user = $users_req->fetch(PDO::FETCH_ASSOC);

if ($user)
{
	if ($_POST['toupdate'] == 'password')
	{
		if ((!preg_match('/.{6,}/', $_POST['update']) && print("Password is too short<br/>"))
		|| (!preg_match('/[0-9]/', $_POST['update']) && print("Password must have at least 1 number<br/>"))
		|| (!preg_match('/[A-Z]/', $_POST['update']) && print("Password must have at least 1 capital letter<br/>"))
		|| (!preg_match('/[^A-Za-z0-9]/', $_POST['update']) && print("Password must have at least 1 special character<br/>"))
		)
		{
			echo "";
		}
		else
		{
			$req = $conn->prepare("UPDATE `users` SET `password` = :pwd WHERE `username` = :username LIMIT 1");
			$req->bindParam(":pwd", hash('whirlpool', $_POST['update']));
			$req->bindParam(":username", $_POST['name']);
			try
			{
				$req->execute();
			}
			catch(PDOExeption $e)
			{
				echo "Error: ".$e->message();
			}
		}
	}
	else if ($_POST['toupdate'] == 'username')
	{
		$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
		$users_req->bindParam(":username", $_POST['update']);
		$users_req->execute();
		$check = $users_req->fetch(PDO::FETCH_ASSOC);
		if ($check)
			echo "Username Taken";
		else
		{
			$req = $conn->prepare("UPDATE `users` SET `username` = :new WHERE `username` = :username LIMIT 1");
			$req->bindParam(":new", $_POST['update']);
			$req->bindParam(":username", $_POST['name']);
			try
			{
				$req->execute();
			}
			catch(PDOExeption $e)
			{
				echo "Error: ".$e->message();
			}
		}
	}
}
else
	echo "User not found 404???";

?>