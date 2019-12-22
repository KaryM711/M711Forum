<?php require('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<style>
	div {
		border-width: 2px;
		border-style: solid;
		border-color: black;
	}
	</style>
	<title>M711Forum</title>
</head>
<body style="background-color: #eee5e3">
	<h1 style="border: solid #ecb535; color: #2e4a62; text-align: center">M711 Forum</h1>
	<?php
		$query = "SELECT * FROM posts  ORDER BY postdate DESC";
		$result = mysqli_query($conn, $query);
		$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		if(!isset($_SESSION["username"])) {
			echo "<form action='index.php' method='post'>";
			echo "<button name='loginbtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Login</button>";
			echo "<button name='registerbtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Register</button>";
			echo "</form></br></br>";
		}  else {
			echo "<p>Welcome, ".$_SESSION['username'].".</p>";
			echo "<form action='index.php' method='post'>";		
			echo "<button name='logoutbtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Logout</button>";
			echo "<button name='newpostbtn' type='submit'style=width:100px;height:30px;background-color:#ce9613>New post</button>";
			echo "</form></br></br>";
		}
		foreach($posts as $post) {

			$posterid = $post['posterid'];

			$query = "SELECT username FROM users WHERE id='$posterid' LIMIT 1";
			$result = mysqli_query($conn, $query);
			$poster = mysqli_fetch_array($result);
			/*
			echo "<center><div><h4 style=color:#172531; text-align:center;>".$post['title']."</h4>";
			echo "<h5 style= border: solid #ecb535 1px; color: #2e4a62; text-align: center>".$post['content']."</h5>";
			echo "<p style=text-align:right;>Written on ".$post['postdate']." by ".$poster['username']."</p></div>";
			echo "\n";*/

			echo "<center><div><a href='thread.php?id=".$post['postid']."''><label style='text-align:left'>".$post['title']."</label></a>\t<label text-align:right>Written by ".$poster['username']." on ".$post['postdate']."</label></div></center>";
		}
		mysqli_close($conn);

		if(isset($_POST['registerbtn'])) {
			header("location: register.php");
		}

		if(isset($_POST['loginbtn'])) {
			header("location: login.php");
		}

		if(isset($_POST['logoutbtn'])) {
			unset($_SESSION['username']);
			header("Refresh:0");
		}
		if(isset($_POST['newpostbtn'])) {
			header("location: newpost.php");
		}
	?>
</body>
</html>