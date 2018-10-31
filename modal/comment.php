<?php
	set_include_path ("../");
	require 'config/setup.php';
	session_start();

	if (isset($_SESSION['login']))
	{
		$message = $_POST['content'];

		$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
		$users_req->bindParam(":username", $_SESSION['login']);
		$users_req->execute();
		$user = $users_req->fetch(PDO::FETCH_ASSOC);

		if ($user)
		{
			$statement = $conn->prepare("INSERT INTO comments(`uploaderID`, `postID`, `content`) VALUE (:user, :post, :content)");
			$statement->bindParam(":post", $_POST['post']);
			$statement->bindParam(":user", $user['id']);
			$statement->bindParam(":content", $message);
			$statement->execute();
		}
		else echo "Must Log In";
	}
	else echo "Must Log In";
?>