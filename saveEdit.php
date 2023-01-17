<?php
session_start();
$user_id = $_SESSION['user_id'];
$story_id = $_POST['story_id'];
$_SESSION['story_id'] = $_POST['story_id'];

$story_contents = $_POST['contents'];
$story_title = $_POST['title'];
$story_link =$_POST['link'];
if(trim($story_title) == ""){
        echo "Title is empty!";
        echo sprintf("<br><a href=\"editStory.php?story_id=%s\">Back to edit</a>",htmlspecialchars( $story_id ));
        echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
        
}
else if(trim($story_contents) == ""){
        echo "Content is empty!";
        echo sprintf("<br><a href=\"editStory.php?story_id=%s\">Back to edit</a>",htmlspecialchars( $story_id ));
        echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
}
else{
require 'database.php';
if(trim($story_link)){
        $stmt = $mysqli->prepare("update stories SET title = ?, contents = ?, link = ? where id = ?");
        if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
        }
 
        $stmt->bind_param('ssss', $story_title, $story_contents, $story_link, $story_id);
        $stmt->execute();
        $stmt->close();
}else{
        $stmt = $mysqli->prepare("update stories SET title = ?, contents = ?, link = NULL where id = ?");
        if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
        }
 
        $stmt->bind_param('sss', $story_title, $story_contents, $story_id);
        $stmt->execute();
        $stmt->close();
}

header('Location: mainpage.php');
}
?>

