<?php
session_start();
$username = $_SESSION['user_id'];

$story_contents = $_POST['contents'];
$story_title = $_POST['title'];
$story_link =$_POST['link'];
if(trim($story_title) == ""){
    echo "Title is empty!";
    echo sprintf("<br><a href=\"postStory.php\">Back to post</a>");
    echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
    
}
else if(trim($story_contents) == ""){
    echo "Content is empty!";
    echo sprintf("<br><a href=\"postStory.php\">Back to post</a>");
    echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
}
else{
require 'database.php';
$stmt = $mysqli->prepare("insert into stories (title, contents, author_id, link) values (?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ssss', $story_title, $story_contents, $username, $story_link);
$stmt->execute();
$stmt->close();
header('Location: mainpage.php');
}
?>