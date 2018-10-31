<?php
	set_include_path ("../");
	require 'config/setup.php';
	
	$img = file_get_contents($argv[1]);

	$img = str_replace(" ", "+", $img);
	$img = 'data:image/png;base64,'.$img;

	$statement = $conn->prepare("INSERT INTO stickers(`img`) VALUE (:img)");
	$statement->bindParam(":img", $img);
	$statement->execute();
?>