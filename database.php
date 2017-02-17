<?php
    
    session_start();

    function dbConnect()
    {
        //You must use your details here in order to connect to database
        $connection = mysqli_connect("localhost", "username", "password", "dbname") or exit("Couldn't connect to database");
        return $connection;
    }

    function selectUser($connection, $column, $condition, $value)
    {
        $query = mysqli_query($connection, "select $column from users where $condition='$value'");
        return $query;
    }
    
    function addUser($connection, $fullname, $username, $password, $date, $email)
    {       
        $random = rand(23456789, 98765432);
        $to = $email;
        $subject = "Activate your account!";
        $headers = "From: admin@auth.com";
        $body = "Hello $username, \n\nYou registered and need to activate your account. Click"
                . " the link below or paste it into the URL bar of your browser\n\n"
                . "http://localhost:8000/activate.php?random=$random \n\nThanks! ";
        $server = "smtp.gmail.com";
        ini_set("SMTP", $server);
        
        if (!mail($to, $subject, $body, $headers)) {
            echo "We couldn't sign you up at this time. Please try again later.";
        } else {
        
            $query = mysqli_query(
                    $connection, 
                    "insert into users(name, username, password, date, email, random, activated) values(
                     '$fullname', '$username', '$password', '$date', '$email', '$random', '0') "
            );
            
            
            return $query;
        }        
    }
    
    function updateUserPassword($connection, $username, $newpassword)
    {
        $password = md5($newpassword);
        $query = mysqli_query($connection, "update users set password='$password' where username='$username'");
        
        return $query;
    }
    
    function activateUserAccount($connection, $random)
    {
        $query = selectUser($connection, 'activated', 'random', $random);
        $result = mysqli_num_rows($query);
            
        if ($result === 1) {
            
            $row = mysqli_fetch_assoc($query);
            $activated = $row['activated'];
            
            if ($activated == "1") {
                exit("Your account has been activated! You can <a href='index.php'>log in</a>.");
            } elseif ($activated == "0") {
                $query = mysqli_query($connection, "update users set activated='1' where random='$random' ");
                echo "Your account is now active! You can <a href='index.php'>log in</a>.";
            }
        } else {
            exit("Data is not present or is wrong!");
        }
        
    }
    
    function isLoggedIn()
    {
        $cookie = filter_input(INPUT_COOKIE, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($_SESSION['username']) || isset($cookie)) {
            $loggedin = TRUE;
            return $loggedin;
        }
    }

    
