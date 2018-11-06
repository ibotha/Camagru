<?php
if (file_get_contents($_GET['pic']))
{
	set_include_path ("../");
	require 'config/setup.php';
	
	$img = base64_encode(file_get_contents($_GET['pic']));

	$img = str_replace(" ", "+", $img);
	$img = 'data:image/png;base64,'.$img;

	$statement = $conn->prepare("INSERT INTO stickers(`img`) VALUE (:img)");
	$statement->bindParam(":img", $img);
	$statement->execute();
	header("Location: addSticker.php");
}
else {
?>
	<form action="addSticker.php" method="get">
		<input name="pic">
	</form>
<?php } ?>