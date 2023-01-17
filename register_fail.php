<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Registration</title>
</head>
<body>
    <?php
    session_start();

    $username = $_SESSION['registerUsername'];
    echo sprintf("<h1>Error: Username %s already exists!</h1>", $registerUsername);
    session_destroy();
    // echo sprintf("<a href="portal.php">Back to login</a>");

    ?>
    <a href="portal.php">Back to login/register</a>
</body>
</html>