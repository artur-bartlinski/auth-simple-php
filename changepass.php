<?php
include 'database.php';

if (isLoggedIn()) {
    
    $submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if ($submit) {
        
        $oldpass = filter_input(INPUT_POST, 'oldpass', FILTER_SANITIZE_SPECIAL_CHARS);
        $newpass = filter_input(INPUT_POST, 'newpass', FILTER_SANITIZE_SPECIAL_CHARS);
        $repeatnewpass = filter_input(INPUT_POST, 'repeatnewpass', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $connect = dbConnect();
        $query = selectUser($connect, $user);
        $row = mysqli_fetch_assoc($query);
        
        $oldpassdb = $row['password'];
        if ($oldpassdb === md5($oldpass)) {
            
            // Alternatively you could use some PHP built-in string comparing function 
            if ($newpass === $repeatnewpass) {                
                
                $query = updateUserPassword($connect, $user, $newpass);
                
                if ($query) {
                    
                    $_SESSION = array();        
                    session_destroy();
                    
                    setcookie("username", "" ,time()-7200);
                    
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
    
        echo "<h3>Change password</h3>"
             . "<form action='changepass.php' method='post'>"
             . "Old password: <input type='text' name='oldpass'><p>"
             . "New password: <input type='password' name='newpass'><p>"
             . "Repeat new password: <input type='password' name='repeatnewpass'><p>"
             . "<input type='submit' name='submit' value='Change password'>"
             . "</form> ";
    }
} else {
    exit("You must be logged in to change your password!");
}