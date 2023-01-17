<?php
session_start();
$user_id = $_SESSION['user_id'];
$comment_id = $_POST['comment_id'];
$story_id = $_POST['story_id'];
$_SESSION['story_id'] = $_POST['story_id'];


$comment_contents = $_POST['contents'];
if(trim($comment_contents) == ""){
    echo "Comment is empty!";
    echo sprintf("<br><a href=\"editComment.php?story_id=%s&amp;comment_id=%s\">Edit Comment</a>",htmlspecialchars( $story_id),htmlspecialchars( $comment_id ));
    echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
    
}
else{
require 'database.php';

$stmt = $mysqli->prepare("update comments SET contents = ? where id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ss', $comment_contents, $comment_id);
$stmt->execute();
$stmt->close();
header('Location: viewStory.php?story_id='.htmlspecialchars($story_id));
}
?>