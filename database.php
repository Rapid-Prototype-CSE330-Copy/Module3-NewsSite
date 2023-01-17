<?php
// Content of database.php
// $mysqli = new mysqli('localhost', 'username', 'password', 'databasename');
$mysqli = new mysqli('localhost', 'cse330', 'cse330', 'module3_group');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>