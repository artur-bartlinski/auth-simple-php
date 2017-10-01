<?php

use classes\User;

require_once 'templates/header.php';

$user = new User();

if ($user->isLoggedIn()) {
    $_SESSION = array();

    session_destroy();

    setcookie("username", "", time()-7200);

    echo "You've been logged out. Click <a href='index.php'>here</a> to return to the main page.";
} else {
    exit("You must be logged in to see this page!");
}
