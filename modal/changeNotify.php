<?php
session_start();
set_include_path ("../");
require 'config/database.php';

$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
$users_req->bindParam(":username", $_SESSION['login']);
$users_req->execute();
$user = $users_req->fetch(PDO::FETCH_ASSOC);

if ($user)
{
	$req = $conn->prepare("UPDATE `users` SET `notify` = :note WHERE `users`.`username` = :user;");
	$val = (($_POST['note'] == 'true') ? 1 : 0);
	$req->bindParam("note", $val);
	$req->bindParam("user", ($user['username']));
	try
	{
		$req->execute();
	}
	catch(PDOExeption $e)
	{
		echo "Error: ".$e->message();
	}
}
else
	echo "must log in";
?>