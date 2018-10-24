<?php

function sendEmail($email, $verif)
{
	$to = $email;
	
	$subject = 'Verify Your Camagru Account';
	$message = '
	<html>
	<head>
	<title>Verify your Camagru account</title>
	</head>
	<body>
	<p>To Verify your Camagru account click <a href="http://localhost:8080/Camagru/verify.php?key='.$verif.'">here.</a></p>
	</body>
	</html>
	';
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	$headers[] = 'From: Camagru <no-reply@camagru.africa>';
	if (mail($to, $subject, $message, implode("\r\n", $headers)))
		return true;
	else
		return false;
}

require 'config/setup.php';
$password = hash('whirlpool', $_POST['password']);
$sql = "SELECT * FROM `users` WHERE email = :email OR username = :username LIMIT 1";
$users_req = $conn->prepare($sql);
if (!preg_match('/[^ ]{1,}@[^ ]{1,}/', $_POST['email']) && $_POST['state'] == 'signup')
{
	echo "Invalid Email";
}
else
{
	$users_req->bindParam(":email", $_POST['email']);
	$users_req->bindParam(":username", $_POST['username']);
	$users_req->execute();
	$users = $users_req->fetch(PDO:: FETCH_ASSOC);
	if ($users)
		echo "Username or Email Taken";
	else
	{
		$verif = hash('sha256', time() + $_POST['username']);
		$add = $conn->prepare("INSERT INTO users(username, email, `password`, verif) VALUES (:username, :email, :pwd, :verif)");
		$add->bindParam(":username", $_POST['username']);
		$add->bindParam(":email", $_POST['email']);
		$add->bindParam(":pwd", $password);
		$add->bindParam(":verif", $verif);
		if (sendEmail($_POST['email'], $verif))
		{
			try
			{
				$add->execute();
			}
			catch(PDOExeption $e)
			{
				echo "Error: ".$e->message();
			}
		}
		else
			echo "Failed to Send";
	}
}
?>