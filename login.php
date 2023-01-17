<?php
session_start();

//access database
require 'database.php';

//get userinput
$username = $mysqli->real_escape_string($_POST['username']);
$guessedPassword = $mysqli->real_escape_string($_POST['password']);
// echo sprintf("<h1>username: %s</h1>", $username);
// echo sprintf("<h1>pwdguess: %s</h1>", $guessedPassword);

// prevent csrf
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

// Check if username&password are valid
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	echo sprintf("<br><a href=\"portal.php\">Back to login/register</a>");
	exit;
}
if( !preg_match('/^[\w_\-]+$/', $guessedPassword) ){
	echo "Invalid password";
	echo sprintf("<br><a href=\"portal.php\">Back to login/register</a>");
	exit;
}



// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $user_id, $hashedPassword);
$stmt->fetch();

$guessedPassword = $_POST['password'];
// Compare the submitted password to the actual password hash
$stmt->close();

// echo sprintf("<h1>cnt:%s; userid:%s; hashedpassword:%s</h1>", $cnt, $user_id, $hashedPassword);

if($cnt == 1 && password_verify($guessedPassword, $hashedPassword)){
	// Login succeeded!
	$_SESSION['user_id'] = $user_id;
    echo sprintf("login succeed. user id is %s", $user_id);
    header("Location: mainpage.php");
	// Redirect to your target page
} else{
	// Login failed; redirect back to the login screen
    echo sprintf("<h1>Login failed. Your username and password does not match our records</h1>");
    echo sprintf("<br><a href=\"portal.php\">Back to login/register</a>");
    session_destroy();
    exit;
}

?>