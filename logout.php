<?php

    session_start();
    
    
    if ($_SESSION['username']) {
        $_SESSION = array();
        
        session_destroy();
    
        echo "You've been logged out. Click <a href='index.php'>here</a> to return to the main page.";
        
    } else {
        exit("You must be logged in to see this page!");
    }
    

