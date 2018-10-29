<?php
	set_include_path("../");
	require 'config/setup.php';
	if ($_POST['key'])
	{
		echo '<p class="big">';
		$sql = "SELECT * FROM `users` WHERE verif = :verif LIMIT 1";
		$users_req = $conn->prepare($sql);
		$users_req->bindParam(":verif", $_POST['key']);
		$users_req->execute();
		$row = $users_req->fetch(PDO::FETCH_ASSOC);
		if ($row)
		{
			$activate = "UPDATE users SET `active` = 1 WHERE verif = :verif LIMIT 1;";
			$act = $conn->prepare($activate);
			$act->bindParam(":verif", $_POST['key']);
			$act->execute();
			echo 'Account Verified!';
		}
		else
		{
			echo 'Invalid Verification key';
		}
		echo '</p>';
	}
	else if ($_POST['forgot'])
	{ ?>
		<form method="post" action="index.php">
		<div class="field" id="password" style="display: initial">
			<input id="passwordinput" type="password" placeholder="Password">
		</div>
		<div class="field" id="confirm" style="display: initial">
			<input id="confirminput" type="password" placeholder="Confirm Password">
		</div>
		<button type="submit" id="submit" style="display: initial">OK</button>
	<?php }
?>