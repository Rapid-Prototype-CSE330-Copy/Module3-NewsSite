<?php
echo "hell0";
session_start();

$story_id = $_SESSION['story_id'];
$user_id = $_SESSION['user_id'];
echo sprintf("<h1>storyid: %s</h1>", $story_id);

// access database
require 'database.php';
$stmt = $mysqli->prepare("select likes, likes_user_id_string from stories where id=?;");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
$stmt->bind_param('s', $story_id);
$stmt->execute();
$stmt->bind_result($likes, $likers_id_string);
$stmt->fetch();
$stmt->close();

echo sprintf("<h1>likes: %u; string: %s</h1>", $likes, $likers_id_string);

$likes = $likes + 1;
$likers_id_string = $likers_id_string . sprintf(",%s", $user_id);
echo sprintf("<h1>likes: %u; string: %s</h1>", $likes, $likers_id_string);

$stmt = $mysqli->prepare("update stories set likes=?, likes_user_id_string=?
                        where id=?;");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
$stmt->bind_param('sss', $likes, $likers_id_string, $story_id);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$returnLocation = 'viewStory.php?story_id=' . $story_id;

header(sprintf("Location: %s", htmlentities($returnLocation)));

?>