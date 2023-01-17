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
$_SESSION['story_id'] = $_GET['story_id'];

?>
<form action="saveEdit.php" method="post" name="saveEdit">
	<label for="title">Title:</label>
	<textarea name="title" id="title" rows="1" cols="150">
		<?php 
			// access database
			require 'database.php';
			$stmt = $mysqli->prepare("select title from stories where id=?");
			// $stmt->bind_param('s', $registerUsername);
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('s', $story_id);
			$stmt->execute();
			$stmt->bind_result($title);
			$stmt->fetch();
			$stmt->close();
			echo sprintf(trim($title));
		?>
	</textarea>
	<br>
	<label for="contents">Content:</label>
	<textarea name="contents" id="contents" rows="20" cols="150">
		<?php 
			// access database
			require 'database.php';
			$stmt = $mysqli->prepare("select contents from stories where id=?");
			// $stmt->bind_param('s', $registerUsername);
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('s', $story_id);
			$stmt->execute();
			$stmt->bind_result($contents);
			$stmt->fetch();
			$stmt->close();
			echo sprintf(trim($contents));
		?>
	</textarea>
	<br>
	<label for="link">Story Link:</label>
	<textarea type="text" name="link" id="link" rows="1" cols="150">
		<?php 
			// access database
			require 'database.php';
			$stmt = $mysqli->prepare("select link from stories where id=?");
			// $stmt->bind_param('s', $registerUsername);
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('s', $story_id);
			$stmt->execute();
			$stmt->bind_result($link);
			$stmt->fetch();
			$stmt->close();
			echo sprintf(trim($link));
		?>
	</textarea>
	<br>
	<input type="submit" value="Save Edited Story" />
	<input type="reset" />
    <input type = "hidden" name = "story_id" value="<?php echo $story_id; ?>">
</form>
</body>
</html>
