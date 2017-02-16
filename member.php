<?php
    
    session_start();

    if ($_SESSION['username']) {
        echo "Welcome, " . $_SESSION['username'] . "! <br>Click <a href='logout.php'>here</a> to logout."
                . "<br>Click <a href='changepass.php'>here</a> to change your password.";
    } else {
        exit("You must be logged in to see this page!");
    }
    
    
