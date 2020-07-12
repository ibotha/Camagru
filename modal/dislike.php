<?php
	set_include_path ("../");
	require 'config/database.php';
	$statement = $conn->prepare("DELETE FROM `likes` WHERE uploaderID = :user AND postID = :post");
	$statement->bindParam(":user", $_POST['user']);
	$statement->bindParam(":post", $_POST['post']);
	$statement->execute();
?>