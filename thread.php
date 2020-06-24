<?php
/*
	Thread.php - master
	Author: adri711
	Language: php
	Written on 23/06/2020
*/

require("database.php");
require("header.php");
$threadid = $_GET['id'];
$query = "SELECT * FROM posts WHERE id='$threadid' LIMIT 1";
$result = mysqli_query($db, $query);
$boardid = -1;
if(mysqli_num_rows($result) > 0)
{
	/* Fetching information from the database */
	$row  = $result->fetch_assoc();
	$title = $row['title'];
	$content = $row['content'];
	$boardid = $row['boardid'];
	$query = "SELECT name, categoryid FROM boards WHERE id='$row[boardid]' LIMIT 1";
	$result = mysqli_query($db, $query);
	$result = $result->fetch_assoc();
	$boardname = $result['name'];
	$query = "SELECT name FROM categories WHERE id='$result[categoryid]'";
	$result = mysqli_query($db, $query);
	$result = $result->fetch_assoc();
	$categoryname = $result['name'];

	$query = "SELECT username,rank FROM users WHERE id='$row[posterid]' LIMIT 1";
	$result = $db->query($query);
	$result = $result->fetch_assoc();

	$postername = $result['username'];
	$query = "SELECT name FROM ranks WHERE id='$result[rank]'";
	$result = $db->query($query);
	$result = $result->fetch_assoc();
	$rankname = $result['name'];

	/* Creating web page*/
	echo "<div class='box2'>";
	echo "<h2>".FORUM_NAME. " > " . $categoryname . " > ".$boardname." > ".$title."</h2>";
	print("<div class='user_info_container'><a href='profile.php?id=1' style='margin: 4px; color:black; text_decoration:underline;' class='namebtn'>$postername</a>");
	print("<p>$rankname</p>");
	print("<img style='padding:5px' src='default_avatar.png' width=60 height=60></img></div>");
	echo "<p style='margin: 5px;'>".$content."</p>";
	echo "</div>";


	/* REPLIES */
	$query = "SELECT * FROM replies WHERE postid='$_GET[id]'";
	$result = $db->query($query);
	foreach($result as $res)
	{
		$user_info = $db->query("SELECT username, rank FROM users WHERE id='$res[posterid]'");
		$user_info = $user_info->fetch_assoc();
		$rank_name = $db->query("SELECT name FROM ranks WHERE id='$user_info[rank]'");
		$rank_name = $rank_name->fetch_assoc();
		echo "<div class='box2'>";
		echo "<h2>Written on $res[replydate]</h2>";
		echo "<div class='user_info_container'>";
		echo "<a href='profile.php?id=$res[posterid]' style='margin: 4px; color:black; text_decoration:underline;' class='namebtn'>$user_info[username]</a>";
		echo "<p>$rank_name[name]</p>";
		print("<img style='padding:5px' src='default_avatar.png' width=60 height=60></img></div>");
		echo "<p style='margin: 5px;'>".$res['content']."</p>";
		echo "</div>";
	}
	if(isset($_SESSION['username'])){
		echo "<div class='box3'>";
		$forum_page->create_html_form("POST", "");
		echo "<textarea name=reply_input placeholder='Write a reply here...' style='margin: 10px;resize:none; width:350px; height: 120px;'></textarea><br>";
		echo "<input type=submit value='reply' name='reply_button' style='margin-left:15px'></div>";
		$forum_page->close_html_form();	
	}
}
else {
	echo "ERROR: Invalid thread id.";
}

if(isset($_POST['reply_button']))
{
	if(!isset($_SESSION['username'])) {
		header("location: login.php");
	}
	else {
		$viewing_user_info = $db->query("SELECT * FROM users WHERE username='$_SESSION[username]'");
		$viewing_user_info = $viewing_user_info->fetch_assoc();
		$rank_info = $db->query("SELECT * FROM ranks WHERE id='$viewing_user_info[rank]'");
		$rank_info = $rank_info->fetch_assoc();
		$board_info = $db->query("SELECT * FROM boards WHERE id='$boardid'");
		$board_info = $board_info->fetch_assoc();
		$today = date('y-m-d');
		if($rank_info['permission'] >= $board_info['restriction'] || $rank_info['permission'] == -1) {
			$query = "INSERT INTO replies(postid, posterid, content, replydate) VALUES ('$_GET[id]', '$viewing_user_info[id]', '$_POST[reply_input]', '$today')";
			$db->query($query);
			header('Location: '.$_SERVER['REQUEST_URI']);

		}
		else {
			echo "<p style='color:red'>ERROR: You do not have permission to reply/post.</p>";
		}
	}
}

require("footer.php");
?>