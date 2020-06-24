<?php
/* Global vars */
const FORUM_NAME = "M711Forum";


/* Global functions/class */
class document
{
	function create_html_form($method, $action)
	{
		if($method != '')
		{
			print("<form method='$method' action='$action'>");
			return 0;
		}
		return "ERROR 711";
	}
	function close_html_form() {
		print("</form>");
		return 0;
	}
	function create_html_button($name, $text)
	{
		if($name != '')
		{
			print(" <input type=submit name='$name' value='$text' class='casualbtn'>");
			return 0;
		}
		return "ERROR 711";
	}
}

$forum_page = new document();

?>

<!DOCTYPE html>
<html>
	<head lang='en'>
		<title>M711Dimension</title>
		<link type='text/css' rel='stylesheet' href='style.css'/>
		<meta charset="UTF-8"/>
	</head>
	<body>

		<div id='container'>
			<div id='main'>
				<center><img src="logo.png" alt='ERROR' height=135 width=500/></center>
			</div>
			<div id='menu'>
				<h2>Navigation</h2>
				<ul>
					<li><a href="index.php" class='subbutton'>Dashboard</a></li>
					<li><a href="register.php" class='subbutton'>Register</a></li>
					<li><a href="login.php" class='subbutton'>Login</a></li>
					<li><a href='forum.php' class='subbutton'>Forum</a></li>
					<!--<li><a href=''>Credits</a></li>-->
				</ul>
			</div>
			<div id="content">
<?php

if(isset($_SESSION['username']))
{
	echo "<br>Welcome, $_SESSION[username]";
	$result = $db->query("SELECT * FROM `users` WHERE username = '$_SESSION[username]' LIMIT 1");
	$user = $result->fetch_assoc();
	$result = $db->query("SELECT * FROM `ranks` WHERE id = '$user[rank]' LIMIT 1");
	$rank = $result->fetch_assoc();
	$forum_page->create_html_form('post','');
	$forum_page->create_html_button("logoutbtn", "logout");
	if($rank['permission'] == -1 || $rank['permission'] >= 3)
	{
		$forum_page->create_html_button("admin_cp", 'admin control panel');
	}
	$forum_page->close_html_form();
} else {
	$forum_page->create_html_form('POST', '');
	$forum_page->create_html_button('loginbtn', 'Login');
	$forum_page->create_html_button('registerbtn', 'Register');
	$forum_page->close_html_form('POST', '');
}
if(isset($_POST['loginbtn'])){
	header("Location: login.php");
	exit();
}
elseif(isset($_POST['registerbtn'])){
	header("Location: register.php");
	exit();
}
elseif(isset($_POST['logoutbtn'])){
	unset($_SESSION['username']);
	header('Location: '.$_SERVER['REQUEST_URI']);
}
?>