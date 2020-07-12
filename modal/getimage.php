<?php
	set_include_path ("../");
	require 'config/database.php';
	session_start();
	$statement = $conn->prepare("SELECT * FROM `posts` ORDER BY `creationDate` DESC LIMIT ".$_POST['offset'].",".$_POST['amount'].";");
	$statement->execute();
	$posts = $statement->fetchAll();

	if ($_SESSION['login'])
	{
		$users_req = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1");
		$users_req->bindParam(":username", $_SESSION['login']);
		$users_req->execute();
		$user = $users_req->fetch(PDO::FETCH_ASSOC);
	}
	else $user = NULL;

	foreach ($posts as $post)
	{
?>
<div class="post" id="<?php echo $post['id']; ?>">
	<div class="uploader"><?php
			$uploader = $conn->prepare("SELECT * FROM users WHERE id = :id;");
			$uploader->bindParam(":id", $post['uploaderID']);
			$uploader->execute();
			print($uploader->fetch()['username']);
		?>
	</div>
	<div class="posttitle"><?php echo str_replace("<", "&lt;", $post['description']); ?></div>
	<img class="postimg" src="<?='uploads/'.$post['path']?>"/>
	<div class="options" id="post<?php echo $post['id'] ?>" style="height: 40px;">
		<p class="likes"><?php
			$likes = $conn->prepare("SELECT COUNT(*) FROM likes WHERE postID = :id;");
			$likes->bindParam(":id", $post['id']);
			$likes->execute();
			print($likes->fetch()[0]);
		?></p>
		<?php
			echo "<button ";
			if ($user)
			{
				$like = $conn->prepare("SELECT * FROM likes WHERE postID = :id AND uploaderID = :upID;");
				$like->bindParam(":id", $post['id']);
				$like->bindParam(":upID", $user['id']);
				$like->execute();
				if ($like->fetch())
					echo 'style="background-color: rgba(255, 255, 255, 0.5);" onclick="dislike(this, \''.$post['id'].'\', \''.$user['id'].'\')">Like';
				else
					echo 'onclick="like(this, \''.$post['id'].'\', \''.$user['id'].'\')">Like';
			}
			else
				echo 'class="greyed">Like';
			if ($user['id'] == $post['uploaderID'])
				echo "<button onclick='deleteimage(".$post['id'].")'>Delete</button>"
		?></button>
	</div>
	<div id="com<?php echo $post['id']; ?>">
		<?php
			$commentsql = $conn->prepare("SELECT comments.content AS content, users.username as username FROM `comments` LEFT JOIN users ON comments.uploaderID = users.id WHERE postID = :id");
			$commentsql->bindParam(":id", $post['id']);
			$commentsql->execute();
			$comments = $commentsql->fetchAll();
			foreach ($comments as $comment)
			{
				?>
				<div class=comment>
					<div class="commentuploader" style="<?=$_SESSION['login']==$comment['username'] ? 'color: white;' : ''?>"><?=$_SESSION['login']==$comment['username'] ? 'Me' : $comment['username']?>: &nbsp; </div>
					<div class="com">
						<?=$comment['content']?>
					</div>
				</div>
				<?php
			}
		?>
	</div>
	<?php
		if ($user)
			echo "<textarea class='commentbox' id='".$post['id']."' placeholder='comment...'></textarea>".
			"<div class='options'>".
			"<button onclick='comment(".$post['id'].")'>Comment</button>".
			"</div>";
	?>
</div>
<?php	} ?>