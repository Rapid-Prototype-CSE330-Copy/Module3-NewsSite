<?php
session_start();
$user_id = $_SESSION['user_id'];
$story_id = $_POST['story_id'];
$_SESSION['story_id'] = $_POST['story_id'];
$comment_contents = $_POST['comment'];
if(trim($comment_contents) == ""){
    echo "Comment is empty!";
    echo sprintf("<br><a href=\"postComment.php?story_id=%s\">Back to post Comment</a>",htmlspecialchars( $story_id ));
    echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
    
}
else{
require 'database.php';
$stmt = $mysqli->prepare("insert into comments (contents, commenter_id, story_id) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('sss', $comment_contents, $user_id, $story_id);
$stmt->execute();
$stmt->close();
header('Location: viewStory.php?story_id='.htmlspecialchars($story_id));
}
?>