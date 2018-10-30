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
	{
		$sql = "SELECT * FROM `users` WHERE verif = :verif LIMIT 1";
		$users_req = $conn->prepare($sql);
		$users_req->bindParam(":verif", $_POST['forgot']);
		$users_req->execute();
		$row = $users_req->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			echo '<p class="big">'.$row['username'].' Please Complete The Following Form To Change Your Password</p>';
?>
		<div style="width: 40%; margin: auto;">
			<div class="field" id="repassword" style="display: initial">
				<input id="repasswordinput" type="password" placeholder="Password">
			</div>
			<div class="field" id="reconfirm" style="display: initial">
				<input id="reconfirminput" type="password" placeholder="Confirm Password">
			</div>
			<div class="field" id="rename">
				<input id="renameinput" value="<?php echo $row['username']; ?>">
			</div>
			<button type="submit" id="submit" style="display: initial" onclick="repasssubmit()">OK</button>
		</div>
		<?php }
		else
			echo '<p class="big">Invalid Verification key</p>';
	}
?>