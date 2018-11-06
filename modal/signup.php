<?php

session_start();

$_POST['email'] = strtolower($_POST['email']);

function sendEmail($email, $name, $username)
{
	global $conn;
	$verif = hash('sha256', time() + $email);
	$req = $conn->prepare("UPDATE `users` SET `verif` = :verif WHERE `email` = :email LIMIT 1");
	$req->bindParam(":email", $email);
	$req->bindParam(":verif", $verif);
	try
	{
		$req->execute();
	}
	catch(PDOExeption $e)
	{
		echo "Error: ".$e->message();
	}
	$to = $email;
	
	$subject = (($name == 'key') ? 'Verify Your Camagru Account' : 'Reset Your Camagru Password');
	$message = '
	<html>
	<head>
	<title>'.(($name == 'key') ? 'Verify Your Camagru Account' : 'Reset Your Camagru Password').'</title>
	</head>
	<body>
	<p>'.$username.': To '.(($name == 'key') ? 'Verify Your Camagru Account' : 'Reset Your Camagru Password').' click <a href="http://'.$_SERVER['HTTP_HOST'];
	$path = explode('/', $_SERVER['SCRIPT_NAME']);
	$length = count($path) - 2;
	for ($i = 0; $i < $length; $i++)
		$message .= '/'.$path[$i];
	$message .= '?'.$name.'='.$verif.'">here</a>.</p>
	</body>
	</html>
	';
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	$headers[] = 'From: Camagru <no-reply@camagru.africa>';
	return (mail($to, $subject, $message, implode("\r\n", $headers)));
}

set_include_path ("../");
require 'config/setup.php';
$password = hash('whirlpool', $_POST['password']);
if ($_POST['state'] == 'resend')
{
	$users_req = $conn->prepare("SELECT * FROM `users` WHERE `email` = :email LIMIT 1");
	$users_req->bindParam(":email", $_POST['email']);
	$users_req->execute();
	$user = $users_req->fetch(PDO::FETCH_ASSOC);
	if (!$user)
	{
		echo "email not registered";
		return ;
	}
	if ($user['active'])
	{
		echo "email already active";
		return ;
	}
	sendEmail($user['email'], 'key', $user['username']);
} else if ($_POST['state'] == 'forgot')
{
	$users_req = $conn->prepare("SELECT * FROM `users` WHERE `email` = :email LIMIT 1");
	$users_req->bindParam(":email", $_POST['email']);
	$users_req->execute();
	$user = $users_req->fetch(PDO::FETCH_ASSOC);
	if (!$user || !$user['active'])
	{
		echo "email not active";
		return ;
	}
	sendEmail($user['email'], 'forgot', $user['username']);
}
else if (!preg_match('/[^ ]{1,}@[^ ]{1,}/', $_POST['email']) && $_POST['state'] == 'signup')
{
	echo "Invalid Email";
}
else if ($_POST['state'] == 'signup'
		&& ((!preg_match('/.{6,}/', $_POST['password']) && print("Password is too short<br/>"))
		|| (!preg_match('/[0-9]/', $_POST['password']) && print("Password must have at least 1 number<br/>"))
		|| (!preg_match('/[A-Z]/', $_POST['password']) && print("Password must have at least 1 capital letter<br/>"))
		|| (!preg_match('/[^A-Za-z0-9]/', $_POST['password']) && print("Password must have at least 1 special character<br/>"))
		))
{
	echo "";
}
else
{
	$users_req = $conn->prepare("SELECT * FROM `users` WHERE email = :email OR username = :username LIMIT 1");
	$users_req->bindParam(":email", $_POST['email']);
	$users_req->bindParam(":username", $_POST['username']);
	$users_req->execute();
	$users = $users_req->fetch(PDO::FETCH_ASSOC);
	if ($users)
	{
		if ($_POST['state'] == 'login')
		{
			if ($users['password'] == $password)
			{
				if ($users['active'] == 1)
				{
					$_SESSION['login'] = $users['username'];
				}
				else
					echo "Account Not Verified";
			}
			else echo "Password Incorrect";
		}
		else
			echo "Username or Email Taken";
	}
	else
	{
		if ($_POST['state'] == 'signup')
		{
			$add = $conn->prepare("INSERT INTO users(username, email, `password`, verif) VALUES (:username, :email, :pwd, :verif)");
			$add->bindParam(":username", $_POST['username']);
			$add->bindParam(":email", $_POST['email']);
			$add->bindParam(":pwd", $password);
			$a = '0';
			$add->bindParam(":verif", $a);
			try
			{
				$add->execute();
			}
			catch(PDOExeption $e)
			{
				echo "Error: ".$e->message();
			}
			if (!sendEmail($_POST['email'], "key", $_POST['username']))
				echo "Failed to Send";
		}
		else if ($_POST['state'] == 'login')
			echo "Invalid Username";
	}
}
?>