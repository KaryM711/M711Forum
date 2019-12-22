<?php require('db.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<style>
		div {
			border-style: solid;
			border-color: #ecb535;
			border-width: 3px;
			width: 350px;
			height: 200px;
			border-radius: 50px;
		}
	</style>
	<title>M711Forum - Register</title>
</head>
<body style="background-color: #eee5e3">
	<h1 style="border: solid #ecb535; color: #2e4a62; text-align: center">M711 Forum</h1>
	<?php

		if(isset($_SESSION['username'])) {
			header("location: index.php");
		} else {
			echo "Already a member? <a href='login.php'>Click here</a></br></br>";
			echo "<center><form method='post' action='register.php'><div>";
			echo "<label>Username:</label></br><input type='text' name='unameinput'></br>";
			echo "<label>email:</label></br><input type='text' name='uemailinput'></br>";
			echo "<label>password:</label></br><input type='password' name='upasswordinput'></br>";
			echo "<label>repeat password:</label></br><input type='password' name='reupasswordinput'></br>";
			echo "</br><input type='submit' name='registerbtn' value='Register' style='width: 80px; background-color: orange'>";
			echo "</form></div>";
		}

		if(isset($_POST['registerbtn'])) {
			if(empty($_POST['unameinput'])) {
				echo "<p style='color:red'>Username is required.</p>";
			}
			if(empty($_POST['uemailinput'])) {
				echo "<p style='color:red'>Email is required.</p>";
			}
			if(empty($_POST['upasswordinput'])) {
				echo "<p style='color:red'>Password is required.</p>";
			}
			if(empty($_POST['reupasswordinput'])) {
				echo "<p style='color:red'>repeating password is required.</p>";
			}
			if($_POST['reupasswordinput'] != $_POST['upasswordinput'])
			{
				echo "<p style='color:red'>The passwords doesn't match.";
			}

			if(!empty($_POST['unameinput']) && !empty($_POST['uemailinput']) && !empty($_POST['upasswordinput']) && !empty($_POST['reupasswordinput']) && $_POST['upasswordinput'] == $_POST['reupasswordinput']) {
				$username = $_POST['unameinput'];
				$email = $_POST['uemailinput'];
				$password = $_POST['upasswordinput'];
				$query = "INSERT INTO users(username, email, password) VALUES ('$username', '$email', '$password')";
				mysqli_query($conn, $query);
				$_SESSION['username'] = $username;
				header("location:index.php");
			}
		}

	?>
</body>
</html>