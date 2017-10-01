<?php

use classes\Database;
use classes\User;

$pageTitle = 'Change Password';

require_once 'templates/header.php';

$user = new User();
$db = new Database();

if ($user->isLoggedIn()) {
    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
    } else {
        $user = filter_input(INPUT_COOKIE, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    $submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($submit) {
        $oldpass = filter_input(INPUT_POST, 'oldpass', FILTER_SANITIZE_SPECIAL_CHARS);
        $newpass = filter_input(INPUT_POST, 'newpass', FILTER_SANITIZE_SPECIAL_CHARS);
        $repeatnewpass = filter_input(INPUT_POST, 'repeatnewpass', FILTER_SANITIZE_SPECIAL_CHARS);

        $connect = $db->dbConnect();
        $query = $user->selectUser($connect, 'password', 'username', $user);
        $row = mysqli_fetch_assoc($query);

        $oldpassdb = $row['password'];
        if ($oldpassdb === md5($oldpass)) {
            // Alternatively you could use some PHP built-in string comparing function
            if ($newpass === $repeatnewpass) {
                $query = $user->updateUserPassword($connect, $user, $newpass);

                if ($query) {
                    $_SESSION = array();
                    session_destroy();

                    setcookie("username", "", time()-7200);

                    echo "You have updated your password successfully!"
                        . " Click to <a href='index.php'>log in</a> with new password.";
                } else {
                    echo "There was an error! Try again.";
                }
            } else {
                exit("New passwords must be the same! Try again.");
            }
        } else {
            exit("Your old password doesn't match. Enter correct old password!");
        }
    } else {
        include 'templates/forms/changepass_form.html';
    }
} else {
    exit("You must be logged in to change your password!");
}
