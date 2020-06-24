<?php
	require('database.php');
	require('header.php');
	$categories=$db->query("SELECT * FROM categories");	
	foreach($categories as $index=>$category) {
		print('<div class=box>');
		print("<h2>$category[name]</h2><ul>");
		$boards = $db->query("SELECT * FROM boards WHERE categoryid = '$category[id]'");
		foreach($boards as $boardindex=>$board) {
			$result = $db->query("SELECT title FROM posts WHERE boardid = '$board[id]'");
			$totalposts = mysqli_num_rows($result);
			$result = $db->query("SELECT postdate,posterid FROM table ORDER BY id DESC LIMIT 1");
			$postername = 'Unnamed';
			if($result){
				$lastpost = $result->fetch_assoc();
				$user = $db->query("SELECT name from users WHERE id = '$lastpost[posterid]'");
				if($user) {
					$user = $user->fetch_assoc();
					$postername = $user['username'];
				}
			}
			print('<li>');
			print("<a href=forumdisplay.php?id=".$board['id']." class='subbutton'>$board[name] | Total posts: $totalposts | Last post by $postername</a>");
			print("<p>".$board['description']."</p>");
			print('</li>');
		}
		print('</ul></div>');
	}

	require('footer.php');
?>