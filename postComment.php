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
$story_id = $_GET['story_id'];
$_SESSION['story_id'] = $_GET['story_id'];
$user_id = $_SESSION['user_id'];

?>
<form action="uploadComment.php" method="post" name="uploadComment">
	<label for="comment">Comment:</label>
	<textarea name="comment" id="comment" rows="5" cols="100" placeholder="Maximum 65535 characters">

    </textarea>
    <br>
	<input type="submit" value="Upload Comment" />
    <input type = "hidden" name = "story_id" value="<?php echo $story_id; ?>">
	<input type="reset" />
</form>
</body>
</html>