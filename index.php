<?php

include 'database.php';

if (isLoggedIn()) {
    header("Location: member.php");
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login page</title>
    </head>
    <body>
        <h3>Log in</h3>
        <form action="login.php" method="post">
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            <input type="checkbox" name="rememberme"> Remember me<br>
            <input type="submit" name="login" value="Log in">
        </form>
        <p>
            <a href="register.php">Register</a>
        </p>
    </body>
</html>
