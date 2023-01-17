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

// access database
require 'database.php';

if ($user_id){
	$stmt = $mysqli->prepare("select username from users where id=?");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $user_id);
	$stmt->execute();
	$stmt->bind_result($username);
	$stmt->fetch();
	$stmt->close();
	echo sprintf("<h1>Welcome, %s!</h1>", $username);
}else{
	echo sprintf("<h1>Welcome!</h1>");
	echo sprintf("<h3>You are currently visiting this site as a guest.</h3>");
}



echo "_______________________________________________________";
echo sprintf("<h1>All the stories on our site:</h1>");
echo "_______________________________________________________";


// select all stories, 
$stmt = $mysqli->prepare("select stories.id as story_id, title as title, 
						users.username as author_name, likes as likes, 
						link as link  
                        from stories 
                        join users on (stories.author_id=users.id) 
						order by likes desc limit 10;");
// $stmt->bind_param('s', $registerUsername);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->bind_result($story_ids, $titles, $author_usernames, $likes, $links);

echo "<ul>\n";
while($stmt->fetch()){
	if($links){
		echo sprintf("\t<li>
			<a href=\"viewStory.php?story_id=%s\">
			<b>%s</b> 
			</a>
			<i>[%s], </i> 
			<i>%s likes</i>
			<a href='%s'>( %s )</a>
		</li>\n",
		htmlspecialchars( $story_ids ),
		htmlspecialchars( $titles ),
		htmlspecialchars( $author_usernames ),
		htmlspecialchars( $likes ),
		htmlspecialchars( $links ),
		htmlspecialchars( $links ));
		
	}else{
		echo sprintf("\t<li>
			<a href=\"viewStory.php?story_id=%s\">
			<b>%s</b> 
			</a>
			<i>[%s], </i> 
			<i>%s likes</i>
		</li>\n",
		htmlspecialchars( $story_ids ),
		htmlspecialchars( $titles ),
		htmlspecialchars( $author_usernames ),
		htmlspecialchars( $likes ));
		
	}
	
}
echo "</ul>\n";

$stmt->close();

echo "_______________________________________________________";


if($user_id){
	echo sprintf("<h1>Stories you have posted:</h1>");
	$stmt = $mysqli->prepare("select stories.id as story_id, title as title, 
							likes as likes, link as link 
							from stories 
							join users on (stories.author_id=users.id) 
							where users.id=? 
							order by likes desc;");
	// $stmt->bind_param('s', $registerUsername);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $user_id);
	$stmt->execute();
	$stmt->bind_result($story_ids, $titles, $likes, $links);
	if($story_ids){
		echo "<ul>\n";
		while($stmt->fetch()){
			if($links){
				echo sprintf("\t<li>
					<a href=\"viewStory.php?story_id=%s\">
						<b>%s</b> 
					</a>
					<i>, %s likes</i>
					<a href='%s'>( %s )</a>
					</li>\n",
					htmlspecialchars( $story_ids ),
					htmlspecialchars( $titles ),
					htmlspecialchars( $likes ),
					htmlspecialchars( $links ),
					htmlspecialchars( $links ));
					echo sprintf("<br><a href=\"editStory.php?story_id=%s\">Edit</a>",htmlspecialchars( $story_ids ));
    				echo sprintf("<br><a href=\"deleteStory.php?story_id=%s\">Delete</a>",htmlspecialchars( $story_ids ));
				
			}else{
				echo sprintf("\t<li>
					<a href=\"viewStory.php?story_id=%s\">
						<b>%s</b> 
					</a>
					<i>, %s likes</i>
					</li>\n",
					htmlspecialchars( $story_ids ),
					htmlspecialchars( $titles ),
					htmlspecialchars( $likes ));
					echo sprintf("<br><a href=\"editStory.php?story_id=%s\">Edit</a>",htmlspecialchars( $story_ids ));
    				echo sprintf("<br><a href=\"deleteStory.php?story_id=%s\">Delete</a>",htmlspecialchars( $story_ids ));
			
			}
		}
		echo "</ul>\n";
	}else{
		echo "You haven't posted any stories yet!";
	}
	
	$stmt->close();
}
echo "<br>";
echo "\r\n_______________________________________________________";


if($user_id){
	echo sprintf("<br><a href=\"postStory.php\">Post Story</a>");
	echo sprintf("<br><a href=\"logout.php\">Logout</a>");
}else{
	echo sprintf("<br><a href=\"logout.php\">Back to login/register</a>");
}



?>
</body>
</html>