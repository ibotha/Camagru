<?php
	echo '<p class="big">';
	set_include_path("../");
	require 'config/setup.php';
	if ($_POST['key'])
	{
		$sql = "SELECT * FROM `users` WHERE verif = :verif LIMIT 1";
		$users_req = $conn->prepare($sql);
		$users_req->bindParam(":verif", $_POST['key']);
		$users_req->execute();
		$row = $users_req->fetch(PDO::FETCH_ASSOC);
		if ($row)
		{
			$activate = 'UPDATE users SET `active` = 1, `verif` = \''.hash('SHA256', rand(0, 200000)).'\' WHERE verif = :verif LIMIT 1;';
			$act = $conn->prepare($activate);
			$act->bindParam(":verif", $_POST['key']);
			$act->execute();
			echo 'Account Verified!';
		}
		else
		{
			echo 'Invalid Verification key';
		}
	}
	else if ($_POST['forgot'])
	{
		$sql = "SELECT * FROM `users` WHERE verif = :verif LIMIT 1";
		$users_req = $conn->prepare($sql);
		$users_req->bindParam(":verif", $_POST['forgot']);
		$users_req->execute();
		$row = $users_req->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			echo $row['username'].' Please Complete The Following Form To Change Your Password';
?>
		<div style="width: 40%; margin: auto;">
			<div class="field" id="repassword" style="display: initial">
				<input id="repasswordinput" type="password" placeholder="Password">
			</div>
			<div class="field" id="reconfirm" style="display: initial">
				<input id="reconfirminput" type="password" placeholder="Confirm Password">
			</div>
			<div class="field" id="rename">
				<input id="reverifinput" value="<?php echo $row['verif']; ?>">
			</div>
			<button type="submit" id="submit" style="display: initial" onclick="repasssubmit()">OK</button>
		</div>
		<?php }
		else
			echo 'Invalid Verification key';
	}
	echo '</p>';
?>