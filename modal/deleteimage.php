<?php
	set_include_path ("../");
	require 'config/setup.php';
	$statement = $conn->prepare("DELETE FROM `likes` WHERE postID = :post");
	$statement->bindParam(":post", $_POST['id']);
	$statement->execute();
	$statement = $conn->prepare("DELETE FROM `posts` WHERE id = :post");
	$statement->bindParam(":post", $_POST['id']);
	$statement->execute();
?>