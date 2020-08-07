<?php
	/*
		Author: adri711
		Language: php
	*/

	require("database.php");
	require("header.php");
	if(isset($_SESSION['username']))
	{
		$result = $db->query("SELECT rank FROM users WHERE username='$_SESSION[username]' LIMIT 1");
		$result = $result->fetch_assoc();
		$user_rank_id = $result['rank'];
		$result = $db->query("SELECT permission FROM ranks WHERE id='$user_rank_id' LIMIT 1");
		$result = $result->fetch_assoc();
		$permission = $result['permission'];
		$result = $db->query("SELECT restriction FROM boards WHERE id='$_GET[id]' LIMIT 1");
		$result = $result->fetch_assoc();
		$restriction = $result['restriction'];

		if($permission > $restriction || $permission == -1) {
			$forum_page->create_html_form("post", '');
			$forum_page->create_html_button("post_button", "Start a new Thread");
			$forum_page->close_html_form();
		}	
	}

	$query = "SELECT * FROM boards WHERE id='$_GET[id]' LIMIT 1";
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result))
	{
		$row = $result->fetch_assoc();
		echo "<div class='box'>";
		echo "<h2><b>Threads in forum:</b> ", $row['name'], "</h2>";
		$query = "SELECT * FROM posts WHERE boardid='$_GET[id]'";
		$rows = mysqli_query($db, $query);
		if(mysqli_num_rows($rows) > 0)
		{
			foreach($rows as $row)
			{
				$query = "SELECT * FROM users WHERE id='$row[posterid]' LIMIT 1";
				$result = mysqli_query($db, $query);
				$result = $result->fetch_assoc();
				echo "<li style='margin: 10px'><a href='thread.php?id=".$row['id']."'>", $row["title"], "</a> written on 23/06/2020 Last post by <a></a></li><p style=' padding:0.1px; padding-left:3em;'>by <a href='profile.php?id=$result[id]' class='namebtn'>$result[username]</a></p>";
				echo "<hr>";
			}
		}
		else {
			print("This forum is empty.");
		}
	}
	else {
		print("Invalid board id.");
	}
	/* On 'new post' button pressed */
	if(isset($_POST['post_button'])) {
		header("Location: newpost.php?id=$_GET[id]");
	}
	require("footer.php");
?>