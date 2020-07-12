<?php
	set_include_path ("../");
	require 'config/database.php';
	$statement = $conn->prepare("INSERT INTO likes(uploaderID, postID) VALUES (:user, :post)");
	$statement->bindParam(":user", $_POST['user']);
	$statement->bindParam(":post", $_POST['post']);
	try
	{
		$statement->execute();
	}
	catch(PDOExeption $e)
	{
		echo "Error: ".$e->message();
	}
?>