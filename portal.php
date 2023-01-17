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
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    ?>
    <form action="login.php" method="post" name="login">
        <label for="usernameInput">Username:</label>
        <input type="text" name="username" id="usernameInput" />
        <label for="passwordInput">Password:</label>
        <input type="password" name="password" id="passwordInput" />
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" value="Login" />
        <input type="reset" />
    </form>
    <form action="register.php" method="post" name="register">
        <label for="registerNameInput">New Username:</label>
        <input type="text" name="registerUsername" id="registerUsernameInput" />
        <label for="registerPasswordInput">Password:</label>
        <input type="password" name="registerPassword" id="registerPasswordInput" />
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" value="Register" />
        <input type="reset" />
    </form>
    <br>
    <a href="mainpage.php">Continue as guest</a>
    <!-- <textarea placeholder=""></textarea> -->
    
</body>
</html>