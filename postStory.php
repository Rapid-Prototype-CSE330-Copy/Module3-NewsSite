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

?>
<form action="uploadStory.php" method="post" name="upload">
	<label for="title">Title:</label>
	<textarea name="title" id="title" rows="1" cols="150" placeholder="Maximum 255 characters">
		
	</textarea>
	<br>
	<label for="contents">Content:</label>
	<textarea name="contents" id="contents" rows="20" cols="150" placeholder="Maximum 4GB of input">

	</textarea>
	<br>
	<label for="link">Story Link:</label>
	<textarea name="link" id="link" rows="1" cols="150"></textarea>
	<br>
	<input type="submit" value="Upload Story" />
	<input type="reset" />
</form>
</body>
</html>

