<?php
	set_include_path ("../");
	require 'config/setup.php';
	$statement = $conn->prepare("SELECT COUNT(*) FROM posts;");
	$statement->execute();
	print($statement->fetch()[0]);
?>