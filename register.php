<?php
session_start();

// This is a *good* example of how you can implement password-based user authentication in your web application.
require 'database.php';

// echo "====================================================";
// userinput
$_SESSION['registerUsername'] = $mysqli->real_escape_string($_POST['registerUsername']);
$registerUsername = $_SESSION['registerUsername'];
$_SESSION['registerPassword'] = $mysqli->real_escape_string($_POST['registerPassword']);
$registerPassword = $_SESSION['registerPassword'];

// prevent csrf
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}


// Check if username&password are valid
if( !preg_match('/^[\w_\-]+$/', $registerUsername) ){
	echo "Invalid username";
	echo sprintf("<br><a href=\"portal.php\">Back to login/register</a>");
	exit;
}
if( !preg_match('/^[\w_\-]+$/', $registerPassword) ){
	echo "Invalid password";
	echo sprintf("<br><a href=\"portal.php\">Back to login/register</a>");
	exit;
}

// hash the password
$hashed_password = password_hash($registerPassword, PASSWORD_BCRYPT);
// echo sprintf("<h1>hashedpassword: %s</h1>", $hashed_password);



// Check if username already exists
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username=?");
$stmt->bind_param('s', $registerUsername);
$stmt->execute();
$stmt->bind_result($cnt);
$stmt->fetch();
if($cnt > 0){
	// echo sprintf("<h1>Error: Username %s already exists!</h1>", $registerUsername);
	// echo sprintf("<a href=\"portal.php\">Back to login/register page</a>");
	header("Location: register_fail.php");
        exit;
}
$stmt->close();

// Use a prepared statement
// $stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password FROM users WHERE username=?");
$stmt = $mysqli->prepare("insert into users (username, hashed_password) values (?, ?)");
// echo sprintf("<h1>stmt: %s</h1>", $stmt);

// Bind the parameter
$stmt->bind_param('ss', $registerUsername, $hashed_password);
$stmt->execute();
$stmt->close();
echo sprintf("<h1>You have successfully registered as: %s</h1>", $registerUsername);
session_destroy();
echo sprintf("<br><a href=\"portal.php\">Back to login/register</a>");





?>