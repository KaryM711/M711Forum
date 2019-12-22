<?php require('db.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<?php
		$pID = $_GET['id'];
		$query = "SELECT * FROM posts WHERE postid='$pID' LIMIT 1";
		$result = mysqli_query($conn, $query);
		$post = mysqli_fetch_array($result);
		echo "<title>".$post['title']." - M711Forum</title>";
		mysqli_free_result($result);
	?>
	<style>
	div {
		border-style: solid;
		border-color: black;
	}
	</style>
</head>
<body style="background-color: #eee5e3">
	<h1 style="border: solid #ecb535; color: #2e4a62; text-align: center">M711 Forum</h1>
	<?php
		function meow()
		{

			return 3;
		}
		if(!isset($_SESSION["username"])) {
			echo "<form action='index.php' method='post'>";
			echo "<button name='loginbtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Login</button>";
			echo "<button name='registerbtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Register</button>";
			echo "</form></br></br>";
		}  else {
			echo "<p>Welcome, ".$_SESSION['username'].".</p>";
			echo "<form action='thread.php' method='post'>";
			echo "<button name='logoutbtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Logout</button>";
			echo "<button name='homebtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Home page</button>";
			echo "<button name='replybtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Reply</button>";
			echo "</form></br></br>";
		}
		$posterid = $post['posterid'];

		$query = "SELECT username FROM users WHERE id='$posterid' LIMIT 1";
		$result = mysqli_query($conn, $query);
		$poster = mysqli_fetch_array($result);

		echo "<div><h3 style='color:green'>".$poster['username'].": </h3>";
		echo "<p>".$post['content']."";

		if(isset($_POST['replybtn'])) {
			header("location: reply.php?id=".$pID);
		}
		if(isset($_POST['logoutbtn'])) {
			unset($_SESSION['username']);
			header("Refresh:0");
		}
		else if(isset($_POST['homebtn'])){
			header("location: index.php");
		}
	?>
</body>
</html>