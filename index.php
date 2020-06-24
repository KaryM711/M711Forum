<?php
	/* Should always be on top*/
	require('database.php');
	require('header.php');
	if(isset($_SESSION['username'])){
		if($rank['permission'] == -1 or $rank['permission'] >= 3) {
			$forum_page->create_html_button('postbtn', 'Make a new post');
		}
	}

	$query = "SELECT * from posts WHERE boardid = ".DASHBOARD_ID;
	$posts = mysqli_query($db, $query);
	foreach($posts as $post)
	{
		echo "<div class=box>";
		echo "<h2>".$post['title']."</h2>";
		echo $post['content'];
		echo "</div>";
	}
	require('footer.php');
?>