<?php
	$DB_DSN = "127.0.0.1";
	$DB_USER = "root";
	$DB_PASSWORD = "password";
	$DB_NAME = "camagru";

	try
	{
		$db = new PDO("mysql:host=$DB_DSN", $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo "Failed to connect to database: " . $e->getMessage();
	}

	try{
		$sql = "CREATE DATABASE IF NOT EXISTS ".$DB_NAME;
		if($db->exec($sql)){
			try {
				$conn = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $e)
			{
				echo "Failed to connect to database: " . $e->getMessage();
			}
		}
	}
	catch(PDOException $e) {
		echo "Failed to connect to database: " . $e->getMessage();
	}
?>