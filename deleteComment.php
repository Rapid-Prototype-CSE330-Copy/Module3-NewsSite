<?php
session_start();
$user_id = $_SESSION['user_id'];
$comment_id = $_GET['comment_id'];
$story_id = $_GET['story_id'];
$_SESSION['comment_id'] = $_GET['comment_id'];

require 'database.php';
$stmt = $mysqli->prepare("delete from comments where id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $comment_id);
$stmt->execute();
$stmt->close();
header('Location: viewStory.php?story_id='.htmlspecialchars($story_id));
?>