<?php
	session_start();
	unset($_SESSION['login']);
	header("refresh: 0");
?>