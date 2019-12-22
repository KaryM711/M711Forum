<?php require('db.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<title>M711Forum - Login</title>
	<style>
		div {
			border-style: solid;
			border-color: #ecb535;
			border-width: 3px;
			width: 350px;
			height: 200px;
			border-radius: 50px;
  		}
  		input {
  			width: 300px;
  			height: 30px;
  			border-radius: 10px;
  		}

	</style>
</head>
<body style="background-color: #eee5e3">
	<h1 style="border: solid #ecb535; color: #2e4a62; text-align: center">M711 Forum</h1>
	<?php
		if(!isset($_SESSION["username"])) {
			echo "";
			echo "<p>Don't have an account? <a href='register.php'>Click here</a></p>";
			echo "<form method='post>' action='index.php'>";
			echo "<button name='homepagebtn' type='submit' style=width:100px;height:30px;background-color:#ce9613>Home page</button>";
			echo "</form></br></br>";

			echo "<center><form method='post' action='login.php'><div><br><label>Username:</label><br><input type='text' name='usernameinput''></br></br>";
			echo "<label>Password:</label><br><input type='password' name='passwordinput'>";
			echo "<br><br><input type='submit' value='Login' name='loginsubmitbtn'>";
		}  else {
			header("location: index.php");
		}
		if(isset($_POST['registerbtn']) && !isset($_SESSION["username"])) {
			header('register.php');
		}

		if(isset($_POST['loginsubmitbtn'])) {
			if(empty($_POST['usernameinput'])) {
				echo "<p style='color: red;'>Username is required.</p>";
			}
			if(empty($_POST['passwordinput'])) {
				echo "<p style='color:red';>Password is required.</p>";
			}
			else if (!empty($_POST['passwordinput']) && !empty($_POST['usernameinput'])){
				$uname = $_POST['usernameinput'];
				$upassword = $_POST['passwordinput'];
				$query = "SELECT * FROM users WHERE username='$uname' AND password='$upassword'";
				$result = mysqli_query($conn, $query);
				if(mysqli_num_rows($result) == 1) {
					$_SESSION['username'] = $uname;
					header("location: index.php");
				} else {
					echo "<p style='color:red'>Username/password combination doesn't match.</p>";
				}
			}
		}
	?>
</body>
</html>