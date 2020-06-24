<?php
	require('database.php');

	if(isset($_SESSION['username']))
	{	
		header('Location:index.php');
		exit();
	}
	require('header.php');
	echo "<div class='box'>";
	echo "<h2>M711 - Login</h2>";
	echo "<p>In order to play the game you need to have an account, login to your account or <a href='register.php'>register here</a>.</p>";
	echo "<form method='post'>";
	echo "<table>
			<tr>
				<td><p for=usernameinput>Username:</label></td>
				<td>
					<input placeholder='Enter your username'type='text' name='usernameinput' required>
				</td>
			</tr>
			<tr>
				<td><p for=passwordinput>Password:</p></td>
				<td><input placeholder='Enter your password' type='password' name='passwordinput' required></td>
			</tr>
			<tr>
				<td colspan=2>
					<input style='margin:10px; background-color:orange' type='submit' value='Click to login' name=loginsubmit>
				</td>
			</tr>
		</table>";
	echo "</form>";
	echo "</div>";

	if(isset($_POST['loginsubmit'])) {
		$row = $db->query("SELECT * FROM users WHERE username = '$_POST[usernameinput]' AND password = '$_POST[passwordinput]' LIMIT 1");
		if(mysqli_num_rows($row) < 1) {
			//
			print("<p style='color=red;'>We could not find an account with that username and password.</p>");
		} else {
			$user = $row->fetch_assoc();
			session_start();
			$_SESSION['username'] = $user['username'];
			header('Location: index.php');
		}
	}

	require('footer.php');
?>