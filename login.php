<?php

    session_start();
    
    include_once 'database.php';

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($username && $password) {
        
        $connect = dbConnect();
        $query = selectUser($connect, $username);
        
        
        $numrows = mysqli_num_rows($query);
        
        if ($numrows) {
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
                
            } else {
                echo "Incorrect password!";
            }
        } else {
            exit("User does not exist!");
        }
        
    } else {
        exit("Please enter username and password");
    }


    mysqli_close($connect);


