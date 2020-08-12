<?php
require('database.php');
if(isset($_SESSION['username'])){
	header('Location: index.php');
}
require('header.php');
?>

<div class='box'>
<h2>M711D - Register:</h2>
<p>Fill in the blanks to create an account, Or incase you've got an account you can <a href='register.html'>Login here</a>.</p>
<form method='POST' action=register.php>
		<table>
				<tr>
					<td><p for=username>Username:</label></td>
					<td>
						<input placeholder='Enter your username' type='text' name='username' id='username' required>
					</td>
				</tr>
				<tr>
					<td><p for=password>Password:</p></td>
					<td><input placeholder='Enter your password' type='password' name='password' id='password' required></td>
				</tr>
				<tr>
					<td><p for=password>Verify password:</p></td>
					<td><input placeholder='Retype your password' type='password' name='passverif' id='passverif' required></td>	
				</tr>
				<tr>
					<td><p for=email>Email:</td>
					<td><input placeholder='Write down your email' type='email' name='email' id='email'></td>
				</tr>
				<tr>
					<td><p for=emailverif>Email verification:</td>
					<td><input placeholder='Rewrite your email please' type='email' name='emailverif' id='emailverif'></td>
				</tr>
				<tr>
					<td colspan=2>
						<input style='margin:10px; background-color:orange' type='submit' value='Click to register' name=registersmtbtn>
					</td>
				</tr>
		</table>
	</form>
</div>
<?php
$today = date('y/m/d');
if(isset($_POST['registersmtbtn'])){
	if($_POST['password'] == $_POST['passverif'] && $_POST['email'] == $_POST['emailverif']) {
		$result = $db->query("SELECT * FROM users WHERE username = '$_POST[username]' LIMIT 1");
		if(mysqli_num_rows($result) < 1) {
			$result = $db->query("SELECT * FROM users WHERE email = '$_POST[email]' LIMIT 1");
			if(mysqli_num_rows($result) < 1)
			{
				$query = "INSERT INTO users (username, email, password, registerDate, rank) VALUES ('$_POST[username]', '$_POST[email]', '$_POST[password]', '$today', '2')";
				mysqli_query($db,$query);
				$_SESSION['username'] = $_POST['username'];
				header("Location: index.php");
			} else {
				echo "Email already in use.";
			}
		} else {
			echo "username already in use.";
		}
	} else {
		echo "Passwords/Emails don't match.";
	}
}
require('footer.php');
?>
