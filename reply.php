<?php require('db.php');?>
<!DOCTYPE html>
<html>
<head>

	<title>ForumM711 - Reply</title>
</head>
<body style="background-color: #eee5e3">
	<h1 style="border: solid #ecb535; color: #2e4a62; text-align: center">M711 Forum</h1>
	<?php
		if(!isset($_SESSION['username'])) {
			header("location: login.php");	
		} else {
			echo "<form action='reply.php' method='post'"
			echo "<input type='text' name='text' value='button'";
		}

	?>
</body>
</html>