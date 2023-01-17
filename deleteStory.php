<?php
session_start();
$user_id = $_SESSION['user_id'];
$story_id = $_GET['story_id'];
$_SESSION['story_id'] = $_GET['story_id'];

require 'database.php';
$stmt = $mysqli->prepare("delete from stories where id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $story_id);
$stmt->execute();
$stmt->close();
header('Location: mainpage.php');
?>