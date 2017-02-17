<?php
    
    include 'database.php';

    if (isLoggedIn()) {
        echo "Welcome, " . $_SESSION['username'] . filter_input(INPUT_COOKIE, "username", FILTER_SANITIZE_SPECIAL_CHARS) 
                . "! <br>Click <a href='logout.php'>here</a> to logout."
                . "<br>Click <a href='changepass.php'>here</a> to change your password.";
    } else {
        exit("You must be logged in to see this page!");
    }
    
    
