<?php

    include 'database.php';
    
    if (isLoggedIn()) {
        header("Location: member.php");
    }

    echo "<h1>Register</h1>";
    
    
    $submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_SPECIAL_CHARS);
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS); 
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);  
    $repeat_passwd = filter_input(INPUT_POST, 'repeat_passwd', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = date('Y-m-d');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
 
    if ($submit) {
        
        $connect = dbConnect();
        $namecheck = selectUser($connect, $username);
        $count = mysqli_num_rows($namecheck);
        
        if ($count) {
            exit("Username is already in use. Choose another username.");
        }
        
        if ($username && $password && $repeat_passwd && $fullname && $email) {                   
            if ($password === $repeat_passwd) {                
                if (strlen($username) > 25 || strlen($fullname) > 25 || strlen($password) > 25) {                    
                    echo "You can use maximum 25 characters in each field!";
                } elseif (strlen($password) < 6) {                    
                    echo "Password must have minimum 6 characters!";                    
                } else {
                    
                    //This is basic script. In production environment never use md5() function for
                    //hashing your passwords. It is not secure. For more information use google.
                    $password = md5($password);
                    $repeat_passwd = md5($repeat_passwd);
                    
                    $query = addUser($connect, $fullname, $username, $password, $date, $email);
                    
                    if($query) {
                        echo "You have been registered successfully! Please check your e-mail ($email) to activate.";
                    }
                }                
            } else {                
                echo "Your passwords do not match!";
            }                   
        } else {            
            echo "Please fill in all fields!";
        }
    } else {
        
        
?>


<html>
    <form action="register.php" method="post">
        <table>
            <tr>
                <td>Your full name: </td>
                <td><input type="text" name="fullname" value="<?php echo $fullname ?>"></td>
            </tr>
            <tr>
                <td>Choose a username: </td>
                <td><input type="text" name="username" value="<?php echo $username ?>"></td>
            </tr>
            <tr>
                <td>Choose a password: </td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Repeat a password: </td>
                <td><input type="password" name="repeat_passwd"></td>
            </tr>
            <tr>
                <td>E-mail address: </td>
                <td><input type="email" name="email" value="<?php echo $email ?>"></td>
            </tr>
        </table>
        <p><input type="submit" name="submit" value="Register"></p>
    </form>
    
    
</html>

<?php
    
    }
