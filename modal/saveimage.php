<?php
	set_include_path ("../");
	require 'config/database.php';

	session_start();
	if (isset($_SESSION['login']))
	{
		$img = $_POST['img'];

		$img = str_replace(" ", "+", $img);

		$img = base64_decode(str_replace("data:image/png;base64,", "", $img));

		$split = explode("data:image/png;base64,", $_POST['sticker']);

		$target = uniqid().".png";
		$dir = "../uploads";
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}

		foreach ($split as $spli)
		{
			if ($spli)
			{
				$img = imagecreatefromstring($img);
				$stick = base64_decode(preg_replace("/ /", "+", $spli));
				$size = getimagesizefromstring($stick);
				$stick = imagecreatefromstring($stick);
				imagealphablending($img, true);
				imagesavealpha($img, true);
				imagesavealpha($stick, true);
				imagecopy($img, $stick, 0, 0, 0, 0, $size[0], $size[1]);
				imagepng($img, $dir."/".$target);
			}
		}
		$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
		$users_req->bindParam(":username", $_SESSION['login']);
		$users_req->execute();
		$user = $users_req->fetch(PDO::FETCH_ASSOC);

		if ($user)
		{
			$statement = $conn->prepare("INSERT INTO posts(`path`, `description`, `uploaderID`) VALUE (:imgpath, :title, :ID)");
			$statement->bindParam(":imgpath", $target);
			$statement->bindParam(":title", $_POST['title']);
			$statement->bindParam(":ID", $user['id']);
			$statement->execute();
		}
		else echo "Must Log In";
	}
	else echo "Must Log In";
?>