<?php

use classes\User;
use classes\Database;

$pageTitle = 'Sign Up';

require_once 'templates/header.php';

$user = new User();

if ($user->isLoggedIn()) {
    header("Location: member.php");
}

echo "<h1>Register</h1>";


$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_SPECIAL_CHARS);
$fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$repeatPassword = filter_input(INPUT_POST, 'repeat_passwd', FILTER_SANITIZE_SPECIAL_CHARS);
$date = date('Y-m-d');
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);


if ($submit) {
    $db = new Database();
    $connect = $db->dbConnect();
    $namecheck = $user->selectUser($connect, 'username', 'username', $username);
    $count = mysqli_num_rows($namecheck);

    if ($count) {
        exit("Username is already in use. Choose another username.");
    }

    if ($username && $password && $repeatPassword && $fullname && $email) {
        if ($password === $repeatPassword) {
            if (strlen($username) > 25 || strlen($fullname) > 25 || strlen($password) > 25) {
                echo "You can use maximum 25 characters in each field!";
            } elseif (strlen($password) < 6) {
                echo "Password must have minimum 6 characters!";
            } else {
                //This is basic script. In production environment never use md5() function for
                //hashing your passwords. It is not secure. For more information use google.
                $password = md5($password);
                $repeatPassword = md5($repeatPassword);

                $query = $user->addUser($connect, $fullname, $username, $password, $date, $email);

                if ($query) {
                    echo "You have been registered successfully! Please check your e-mail ($email) to activate.";
                }
            }
        } else {
            echo "Your passwords do not match!";
        }
    } else {
        echo "Please fill in all fields!";
    }
}

include 'templates/forms/register_form.html';


