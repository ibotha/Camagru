<?php
	set_include_path ("../");
	require 'config/database.php';
	$statement = $conn->prepare("SELECT `path` FROM `posts` WHERE id = :post");
	$statement->bindParam(":post", $_POST['id']);
	$statement->execute();

	$row = $statement->fetch(PDO::FETCH_ASSOC);
	if ($row)
	{
		unlink('../uploads/'.$row['path']);

		$statement = $conn->prepare("DELETE FROM `posts` WHERE id = :post");
		$statement->bindParam(":post", $_POST['id']);
		$statement->execute();
	}
?>