<?php

require "config/database.php";

$user = "CREATE TABLE IF NOT EXISTS users (".
		"id int NOT NULL AUTO_INCREMENT,".
		"active bool NOT NULL DEFAULT 0,".
		"username varchar(40) NOT NULL UNIQUE,".
		"email varchar(255) NOT NULL UNIQUE,".
		"password varchar(1000) NOT NULL,".
		"creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,".
		"verif varchar(1000) NOT NULL,".
		"likes varchar(1000) NOT NULL DEFAULT 0,".
		"comments varchar(1000) NOT NULL DEFAULT 0,".
		"PRIMARY KEY (id));";
try
{
	$conn->exec($user);
}
catch(PDOException $e)
{
	echo "Failed to create user table: " . $e->getMessage();
}

$post = "CREATE TABLE IF NOT EXISTS posts (".
		"id int NOT NULL AUTO_INCREMENT,".
		"img BLOB(4294967295) NOT NULL,".
		"uploaderID int NOT NULL,".
		"description varchar(255),".
		"creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,".
		"PRIMARY KEY (id));";
try
{
	$conn->exec($post);
}
catch(PDOException $e)
{
	echo "Failed to create post table: " . $e->getMessage();
}

$sticker = "CREATE TABLE IF NOT EXISTS stickers (".
		"id int NOT NULL AUTO_INCREMENT,".
		"img BLOB(4294967295) NOT NULL,".
		"PRIMARY KEY (id));";
try
{
	$conn->exec($sticker);
}
catch(PDOException $e)
{
	echo "Failed to create sticker table: " . $e->getMessage();
}

$comment = "CREATE TABLE IF NOT EXISTS comments (".
		"id int NOT NULL AUTO_INCREMENT,".
		"uploaderID int NOT NULL,".
		"postID int NOT NULL,".
		"content varchar(1000) NOT NULL,".
		"creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,".
		"PRIMARY KEY (id));";
try
{
	$conn->exec($comment);
}
catch(PDOException $e)
{
	echo "Failed to create comment table: " . $e->getMessage();
}

$like = "CREATE TABLE IF NOT EXISTS likes (".
		"uploaderID int NOT NULL,".
		"postID int NOT NULL);";
try
{
	$conn->exec($like);
}
catch(PDOException $e)
{
	echo "Failed to create like table: " . $e->getMessage();
}
?>