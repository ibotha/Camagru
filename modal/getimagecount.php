<?php
	set_include_path ("../");
	require 'config/database.php';
	$statement = $conn->prepare("SELECT COUNT(*) FROM posts;");
	$statement->execute();
	print($statement->fetch()[0]);
?>