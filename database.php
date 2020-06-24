<?php 
/* MySQL host details goes here */
session_start();
$db_host = 'localhost';
$db_port = '3306';
$db_username = 'root';
$db_password = '';
$db_name = 'M711AKJ';

function pass(){
	;
}

/* admin account details */
define("ADMIN_USERNAME", "administrator");
define("ADMIN_PASSWORD", "administrator");
define("ADMIN_EMAIL", "karym4life@gmail.com");
define("DASHBOARD_ID", 0);

$db = mysqli_connect($db_host, $db_username, $db_password,$db_name);
if($db->connect_error){
	die('MySQL connection failed '.$db->connect_error);
}
$query = "SELECT 1 from `users`";
$result = $db->query($query);
if(!$result) {
$query = "CREATE TABLE users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username varchar(30) NOT NULL,
	email varchar(255) NOT NULL,
	password varchar(25) NOT NULL,
	registerDate date NOT NULL,
	birthday date NOT NULL,
	biography varchar(500),
	rank INT(11),
	reputation INT(11))";
mysqli_query($db, $query);
$query = "INSERT INTO users(username,password,email, rank) VALUES ('".ADMIN_USERNAME."', '".ADMIN_PASSWORD."','".ADMIN_EMAIL."', '1')";
$db->query($query);
} 

$query = "SELECT 1 from `posts`";
$result= $db->query($query);
if(!$result){
	$query = "CREATE TABLE posts (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title varchar(100) NOT NULL,
	content varchar(10000) NOT NULL,
	postdate date NOT NULL,
	posterid INT(6) NOT NULL,
	boardid INT(6) NOT NULL,
	ispinned int(6) UNSIGNED NOT NULL)";
	mysqli_query($db, $query);
	$today = date('y/m/d');
	$query = "INSERT INTO posts(title, content, postdate, posterid, boardid) VALUES ('Welcome to your forum.', 'This forum software has been successfuly installed on $today', '$today', '1', '".DASHBOARD_ID."'')";
	$db->query($query);
}
$query = "SELECT 1 from `categories`";
$result=$db->query($query);
if(!$result){
	$query = "CREATE TABLE IF NOT EXISTS categories (
	id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name varchar(64) NOT NULL)";
	mysqli_query($db, $query);
	$query = "INSERT INTO categories (name) VALUES ('Community')";
	mysqli_query($db,$query);
}

$query = "SELECT 1 from `boards`";
$result=$db->query($query);
if(!$result){
	$query = "CREATE TABLE IF NOT EXISTS boards (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name varchar(80) NOT NULL,
		description varchar(200) NOT NULL,
		categoryid int(6) NOT NULL,
		restriction int(6) UNSIGNED
	)";
	mysqli_query($db, $query);
	$query = "INSERT INTO boards (name,description,categoryid,restriction) VALUES ('General', 'You can talk about anything here.', '1', '0')";
	$db->query($query);
}

$query = "SELECT 1 from `ranks`";

$result = $db->query($query);
if(!$result){
	$query = "CREATE TABLE IF NOT EXISTS ranks (
	id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name varchar(64) NOT NULL,
	permission int(6) NOT NULL)";
	mysqli_query($db, $query);
	$query = "INSERT INTO ranks (name, permission) VALUES ('Owner', '-1')";
	$db->query($query);
	$query = "INSERT INTO ranks (name,permission) VALUES ('Member', '1')";
	$db->query($query);
}

$query = "SELECT 1 FROM `replies`";
$result = $db->query($query);
if(!$result) {
	$query = "CREATE TABLE IF NOT EXISTS replies (
	id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	postid int(6) NOT NULL,
	posterid int(6) NOT NULL,
	content varchar(5000) NOT NULL, 
	replydate date NOT NULL)";
	mysqli_query($db, $query);
}

//$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//header("Location: forum.php");
$url = '';
$x = pathinfo($url);
echo $x['filename'];
?>