<?php
	set_include_path ("../");
	require 'config/setup.php';
	$statement = $conn->prepare("SELECT * FROM stickers;");
	$statement->execute();
	$posts = $statement->fetchAll();

	foreach ($posts as $post)
	{
?>
<div class="post">
	<img class="postimg" src="<?php echo $post['img']; ?>">
</div>
<?php	} ?>