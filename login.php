<?php

use classes\User;
use classes\Database;

require_once 'templates/header.php';

$user = new User();

if ($user->isLoggedIn()) {
    header("Location: member.php");
}

if (filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS)) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $rememberme = filter_input(INPUT_POST, 'rememberme', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!($username && $password)) {
        exit("Please enter username and password!");
    } else {
        $db = new Database();
        $connect = $db->dbConnect();
        $query = $user->selectUser($connect, '*', 'username', $username);


        $numrows = mysqli_num_rows($query);

        if (!$numrows) {
            exit("User does not exist!");
        } else {
            $row = mysqli_fetch_assoc($query);
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $activated = $row['activated'];

            if ($activated === "0") {
                exit("Your account has not been activated yet! Please check your e-mail.");
            }



            if ($username === $dbusername && md5($password) === $dbpassword) {
                echo "You're logged in! Click <a href='member.php'>here</a> to enter the member page";

                $_SESSION['username'] = $dbusername;

                if ($rememberme == "on") {
                    setcookie("username", $username, time()+7200);
                }
            } else {
                echo "Incorrect username or password!";
            }
        }
    }
}

header("Location: index.php");