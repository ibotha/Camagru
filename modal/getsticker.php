<?php
	set_include_path ("../");
	require 'config/database.php';
	$stickers = explode(":", $_POST['id']);
	$stmt = "SELECT * FROM stickers";
	if (isset($_POST['id']))
	{
		$stmt .= " WHERE (`id`) IN (";
		$comma = 0;
		foreach ($stickers as $sticker)
		{
			if ($comma)
				$stmt .= ", ";
			else
				$comma = 1;
			$stmt .= "$sticker";
		}
		$stmt .= ");";
	}
	else
		$stmt .= ";";
	$statement = $conn->prepare($stmt);
	$statement->execute();
	$posts = $statement->fetchAll();

	foreach ($posts as $post)
	{
?>
<?php if (!isset($_POST['id'])) { ?><button class="sticker" onclick="selectSticker(<?=$post['id']?>)" id="<?=$post['id']?>"><?php } ?>
	<img <?php if (isset($_POST['id'])) echo 'class="stick"'; ?>src="<?="stickers/".$post['path']?>" id="stick<?=$post['id']?>">
	<?php if (!isset($_POST['id'])) { ?> </button> <?php } ?>
<?php	} ?>