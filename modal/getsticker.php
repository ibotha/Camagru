<?php
	set_include_path ("../");
	require 'config/setup.php';
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
<?php if (!isset($_POST['id'])) { ?><button class="sticker" onclick="selectSticker(<?php echo $post['id']; ?>)" id="<?php echo $post['id']; ?>"><?php } ?>
	<img <?php if (isset($_POST['id'])) echo 'class="stick"'; ?>src="<?php echo $post['img']; ?>">
	<?php if (!isset($_POST['id'])) { ?> </button> <?php } ?>
<?php	} ?>