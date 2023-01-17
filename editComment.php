<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Site</title>
</head>
<body>
<?php
session_start();
$user_id = $_SESSION['user_id'];
$story_id = $_GET['story_id'];
$comment_id = $_GET['comment_id'];
$_SESSION['story_id'] = $_GET['story_id'];
?>
<form action="saveEditComment.php" method="post" name="saveEditComment">
	<label for="contents">Content:</label>
	<textarea name="contents" id="contents" rows="5" cols="100">
        <?php 
			// access database
			require 'database.php';
			$stmt = $mysqli->prepare("select contents from comments where id=?");
			// $stmt->bind_param('s', $registerUsername);
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('s', $comment_id);
			$stmt->execute();
			$stmt->bind_result($contents);
			$stmt->fetch();
			$stmt->close();
			echo sprintf(htmlentities($contents));
		?>
    </textarea>
    <br>
	<input type="submit" value="Save Edited Comment" />
	<input type="reset" />
    <input type = "hidden" name = "comment_id" value="<?php echo $comment_id; ?>">
    <input type = "hidden" name = "story_id" value="<?php echo $story_id; ?>">
</form>
</body>
</html>