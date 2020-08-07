<?php 
require("database.php");
require("header.php");

if(!isset($_SESSION['username'])) {
	header('location: login.php');
}

$forum_page->create_html_form('post', '');
print("<div class='box2'><h2>Title: <input type=text name=title_input style='width:15em'></h2>");
print("<textarea style='margin:10px; resize:none; height:275px; width: 650px;' name=content_input></textarea><br>");
$forum_page->create_html_button('new_thread_button', 'Publish');
$forum_page->close_html_form();
print("</div>");

if(isset($_POST['new_thread_button'])) {
	if($_POST['content_input'] != '' && $_POST['title_input'] !='') {
		$restriction = $db->query("SELECT restriction FROM boards WHERE id='$_GET[id]'");
		$restriction = $restriction->fetch_assoc();
		$restriction = $restriction['restriction'];

		/* Fetching permission... */
		$rank_id = $db->query("SELECT id,rank FROM users WHERE username='$_SESSION[username]' LIMIT 1");
		$rank_id = $rank_id->fetch_assoc();
		$permission = $db->query("SELECT permission FROM ranks WHERE id='$rank_id[rank]' LIMIT 1");
		$perm = $permission->fetch_assoc();
		if($perm['permission'] > $restriction || $perm['permission'] == -1) {
			$today = date('y-m-d');

			$db->query("INSERT INTO posts(title,content, postdate,posterid, boardid) VALUES ('$_POST[title_input]', '$_POST[content_input]', '$today', '$rank_id[id]', '$_GET[id]')");
			header("Location: forumdisplay.php?id=$_GET[id]");
		}
		else {
			print("ERROR: You do not have permission to post in this board.");
		}
	}
}

require("footer.php");
?>