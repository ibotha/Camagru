<?php
	set_include_path ("../");
	require 'config/setup.php';

	session_start();
	if (isset($_SESSION['login']))
	{
		$img = $_POST['img'];

		$img = str_replace(" ", "+", $img);

		$img = base64_decode(str_replace("data:image/png;base64,", "", $img));

		$split = explode("data:image/png;base64,", $_POST['sticker']);
		foreach ($split as $spli)
		{
			if ($spli)
			{
				$img = imagecreatefromstring($img);
				$stick = imagecreatefromstring(base64_decode(preg_replace("/ /", "+", $spli)));
				imagealphablending($img, true);
				imagesavealpha($img, true);
				imagesavealpha($stick, true);
				imagecopy($img, $stick, 20, 20, 0, 0, 200, 230);
				imagepng($img, 'save.png');
				$img = file_get_contents('save.png');
			}
		}

		$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
		$users_req->bindParam(":username", $_SESSION['login']);
		$users_req->execute();
		$user = $users_req->fetch(PDO::FETCH_ASSOC);

		if ($user)
		{
			$statement = $conn->prepare("INSERT INTO posts(`img`, `description`, `uploaderID`) VALUE (:img, :title, :ID)");
			$statement->bindParam(":img", "data:image/png;base64,".base64_encode($img));
			$statement->bindParam(":title", $_POST['title']);
			$statement->bindParam(":ID", $user['id']);
			$statement->execute();
		}
		else echo "Must Log In";
	}
	else echo "Must Log In";
?>