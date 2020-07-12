<?php

	function sendEmail($email, $content, $username, $title, $uploader)
	{
		$to = $email;
		
		$subject = 'New Comment';
		$message = '
		<html>
		<head>
		<title>New Comment</title>
		</head>
		<body>
		<p> Hey '.$username.'<br/>'.$uploader.' commented on your post <span style="color: grey;">'.$title.'</span>:<br/><p style="border: 2px dashed black; margin: 20px;">'.str_replace("<", "&lt;", $content).'</p></p>
		</body>
		</html>
		';
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'From: Camagru <no-reply@camagru.africa>';
		return (mail($to, $subject, $message, implode("\r\n", $headers)));
	}
	set_include_path ("../");
	require 'config/database.php';
	session_start();

	if (isset($_SESSION['login']))
	{
		$message = trim($_POST['content']);

		$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
		$users_req->bindParam(":username", $_SESSION['login']);
		$users_req->execute();
		$user = $users_req->fetch(PDO::FETCH_ASSOC);

		if ($user && $message)
		{
			$statement = $conn->prepare("INSERT INTO comments(`uploaderID`, `postID`, `content`) VALUE (:user, :post, :content)");
			$statement->bindParam(":post", $_POST['post']);
			$statement->bindParam(":user", $user['id']);
			$statement->bindParam(":content", str_replace("<", "&lt;", $message));
			$statement->execute();
			$statement = $conn->prepare("SELECT * FROM `posts` WHERE id = :post LIMIT 1");
			$statement->bindParam(":post", $_POST['post']);
			$statement->execute();
			$post = $statement->fetch();
			$statement = $conn->prepare("SELECT * FROM `users` WHERE id = :user LIMIT 1");
			$statement->bindParam(":user", $post['uploaderID']);
			$statement->execute();
			$uploader = $statement->fetch();
			if ($uploader['notify'])
				sendEmail($uploader['email'], $message, $uploader['username'], $post['description'], $user['username']);
		}
		else echo "Must Log In";
	}
	else echo "Must Log In";
?>