<?php
	session_start();
	$dbhost = "localhost";
	$username= "root";
	$password ="";
	$dbname ="M711Forum";

	$conn = mysqli_connect($dbhost, $username, $password, $dbname);

	if(!$conn) {
		echo "Connection with the datebase failed";
	}
?>