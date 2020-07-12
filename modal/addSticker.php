<?php
if($_GET.key_exists('pic'))
{
	$content=file_get_contents($_GET['pic']);
	if ($content)
	{
		set_include_path ("../");
		require 'config/database.php';

		$ext = strtolower(pathinfo($_GET['pic'],PATHINFO_EXTENSION));

		if (!in_array($ext, ["png", "jpeg", "jpg", "gif"]))
		{
			echo ($ext.": bad file!");
			die();
		}
		$destination = uniqid().$ext;

		$statement = $conn->prepare("INSERT INTO stickers(`path`) VALUE (:imgpath)");
		$statement->bindParam(":imgpath", $destination);
		$statement->execute();
		$dir = '../stickers';
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		copy($_GET['pic'], $dir."/".$destination);
	}
}
?>
<form action="addSticker.php" method="get">
	<input name="pic">
</form>