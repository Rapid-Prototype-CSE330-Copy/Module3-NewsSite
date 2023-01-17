<?php
session_start();

$story_id = $_GET['story_id'];
$_SESSION['story_id'] = $_GET['story_id'];
$user_id = $_SESSION['user_id'];

// echo sprintf("<h1>storyid: %s</h1>", $story_id);

// access database
require 'database.php';
$stmt = $mysqli->prepare("select title as title, contents as contents, 
                        users.username as author_username, likes as likes  
                        from stories join users on (stories.author_id=users.id) 
                        where stories.id=?;");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
$stmt->bind_param('s', $story_id);
$stmt->execute();
$stmt->bind_result($title, $contents, $author_username, $likes);
$stmt->fetch();
$stmt->close();

// print story title, author, and contents
echo sprintf("<h1>%s</h1>", htmlentities($title));
echo sprintf("Posted by: <i><b>%s</b></i><br>", htmlentities($author_username));
echo "____________________________________________________________________________________________________________________________________________________________________________________________________________________________";
echo sprintf("<br>%s<br><br>", htmlentities($contents));
echo "____________________________________________________________________________________________________________________________________________________________________________________________________________________________";

// likes
echo sprintf("<br>Likes: <b>%u</b><br>", $likes);
if($user_id){
    $stmt = $mysqli->prepare("select likes_user_id_string from stories where id=?;");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
    $stmt->bind_param('s', $story_id);
    $stmt->execute();
    $stmt->bind_result($likers_id_string);
    $stmt->fetch();
    $stmt->close();

    $likerIDs = array_map('intval', explode(',', $likers_id_string));
    if(in_array($user_id, $likerIDs)){
        echo sprintf("<i>You have already liked this story.</i>");
    }else{
        echo sprintf('<form action="addLike.php" name="like">
                        <input type="submit" value="Like" />
                    </form>');
    }

}else{
    echo sprintf("<i>Login to express your like to this story</i>");
}

// comments
echo sprintf("<h1>Comments:</h1>");
$stmt = $mysqli->prepare("select users.username as commenter_name, contents as contents
                        from comments join users on (comments.commenter_id=users.id) 
                        where story_id=?;");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
$stmt->bind_param('s', $story_id);
$stmt->execute();
$stmt->bind_result($commenters, $contents);

echo "<ul>\n";
while($stmt->fetch()){
	echo sprintf("\t<li>
			        <i>%s: </i>
                    %s
		        </li>\n",
		htmlspecialchars( $commenters ),
		htmlspecialchars( $contents ));
}
echo "</ul>\n";

$stmt->close();

echo "____________________________________________________________________________________________________________________________________________________________________________________________________________________________";
//users own comments
if($user_id){
    echo sprintf("<h1>Your Comments:</h1>");
$stmt = $mysqli->prepare("select comments.id as comment_id, contents as contents
                        from comments join users on (comments.commenter_id=users.id) 
                        where story_id=? and users.id=?;");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
$stmt->bind_param('ss', $story_id,$user_id);
$stmt->execute();
$stmt->bind_result($comment_id, $contents);

echo "<ul>\n";
while($stmt->fetch()){
	echo sprintf("\t<li>
                    %s
		        </li>\n",
	
		htmlspecialchars( $contents ));
       
        echo sprintf("<br><a href=\"editComment.php?story_id=%s&amp;comment_id=%s\">Edit Comment</a>",htmlspecialchars( $story_id),htmlspecialchars( $comment_id ));
    	echo sprintf("<br><a href=\"deleteComment.php?story_id=%s&amp;comment_id=%s\">Delete Comment</a>",htmlspecialchars( $story_id),htmlspecialchars( $comment_id ));
}
echo "</ul>\n";

$stmt->close();

}


echo "____________________________________________________________________________________________________________________________________________________________________________________________________________________________";

if($user_id){
	echo sprintf("<br><a href=\"postComment.php?story_id=%s\">Post Comment</a>",htmlspecialchars( $story_id ));
	echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
}else{
	echo sprintf("<br><a href=\"mainpage.php\">Back to site</a>");
}


?>