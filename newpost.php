<?php require('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>New post</title>
</head>
<body style="background-color: #eee5e3">
	<h1 style="border: solid #ecb535; color: #2e4a62; text-align: center">M711 Forum</h1>

	<?php
		if(!isset($_SESSION['username'])) {
			header("location: login.php");
		}
		echo "<form action='newpost.php' method='post'><label>Title:</label></br>";
		echo "<input type='text' name='titleinput' style='width: 300px;'></br>";
		echo "<label>Message:</label></br>";
		echo "<input type='text' name='messageinput' style='width:500px;height:300px;'></br></br>";
		echo "<input type='submit' name='postbtn' value='Post' style='width:80px; height:40px; background-color:#456f93'>";
		echo "<input type='submit' name='cancelbtn' value='Cancel' style='width:80px; height:40px; background-color:#456f93'>";
		if(isset($_POST['postbtn'])) {
			if(empty($_POST['titleinput'])){
				echo "<p style='color:red'>The title is required.</p>";
			}
			if(empty($_POST['messageinput'])) {
				echo "<p style='color:red'>The message is required.</p>";
			}
			else if(!empty($_POST['messageinput']) && !empty($_POST['titleinput'])){
				$title = $_POST['titleinput'];
				$msg = $_POST['messageinput'];
				$query = "SELECT * FROM posts WHERE title = '$title'";
				$result = mysqli_query($conn, $query);
				if(mysqli_num_rows($result) >=1) {
					echo "<p style='color:red'>This title is already used, Use another please.</p>";
					mysqli_free_result($result);

				} else {					
					mysqli_free_result($result);
					$uname = $_SESSION['username'];
					$query = "SELECT * FROM users WHERE username = '$uname' LIMIT 1";
					$result = mysqli_query($conn, $query);
					$user = mysqli_fetch_array($result,MYSQLI_ASSOC);
					mysqli_free_result($result);
					$id = $user['id'];

					$query = "INSERT INTO posts(posterid, title,content) VALUES('$id','$title', '$msg')";
					mysqli_query($conn, $query);
					header("location: index.php");
				}
			}
		}
		else if(isset($_POST['cancelbtn'])) {
			header("location: index.php");
		}
	?>
</body>
</html>