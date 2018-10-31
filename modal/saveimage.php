<?php
	set_include_path ("../");
	require 'config/setup.php';

	session_start();
	
	if (isset($_SESSION['login']))
	{
		$img = $_POST['img'];

		$img = str_replace(" ", "+", $img);

		$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
		$users_req->bindParam(":username", $_SESSION['login']);
		$users_req->execute();
		$user = $users_req->fetch(PDO::FETCH_ASSOC);

		if ($user)
		{
			$statement = $conn->prepare("INSERT INTO posts(`img`, `description`, `uploaderID`, `stickers`) VALUE (:img, :title, :ID, :sticker)");
			$statement->bindParam(":img", $img);
			$statement->bindParam(":title", $_POST['title']);
			$statement->bindParam(":sticker", $_POST['sticker']);
			$statement->bindParam(":ID", $user['id']);
			$statement->execute();
		}
		else echo "Must Log In";
	}
	else echo "Must Log In";
?>