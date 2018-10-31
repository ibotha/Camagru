<?php
	$statement = $conn->prepare("SELECT COUNT(*) FROM posts;");
	$statement->execute();
	print($statement->fetch()[0]);
?>