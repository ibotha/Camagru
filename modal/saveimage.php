<?php
	set_include_path ("../");
	require 'config/setup.php';
	
	$img = $_POST['img'];

	$img = str_replace(" ", "+", $img);

	$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
	$users_req->bindParam(":username", $_POST['name']);
	$users_req->execute();
	$user = $users_req->fetch(PDO::FETCH_ASSOC);

	if ($user)
	{
		$statement = $conn->prepare("INSERT INTO posts(`img`, `description`, `uploaderID`) VALUE (:img, :title, :ID)");
		$statement->bindParam(":img", $img);
		$statement->bindParam(":title", $_POST['title']);
		$statement->bindParam(":ID", $user['id']);
		$statement->execute();
	}
	else echo "Must Log In";
?>