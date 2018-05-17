<?php

require('core/init.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    try{
        
        //validate form coming in
        $validate = new Validate();
        
        $first_name = $validate->isStrValid($_POST['first_name']);
        $last_name = $validate->isStrValid($_POST['last_name']);
        $username = $validate->isStrValid($_POST['username']);
        $email = $validate->isEmailValid($_POST['email']);
        $pass = $validate->isStrValid($_POST['pass']);
        $confirm_pass = $validate->isStrValid($_POST['confirm_pass']);
        
        //check if all fields have been entered in to with correct data
        if($first_name && $last_name && $username && $email && $pass && $confirm_pass){
            //check to see if password and confirm password match
            if($pass == $confirm_pass){
                //now check username and email do not exist in database already
                $q = "SELECT username, email FROM users WHERE username='$username' OR email='$email'";
                $r = $pdo->query($q);
                
                if($r && $r->rowCount() == 0){ //if query ran ok and returned 0 records (i.e. no current user with inputted email or username - insert record in to database)
                    $q = "INSERT INTO users(email, username, first_name, last_name, pass, member_type, reg_date)VALUES(:email, :username, :first_name, :last_name, SHA1(:pass), 0, NOW())";
                    $stmt = $pdo->prepare($q);
                    $r = $stmt->execute(array(':email' => $email, ':username' => $username, ':first_name' => $first_name, ':last_name' => $last_name, ':pass' => $pass));
                    
                    if($r){ //if query ran ok - user inserted in to database. Display page
                        $page_title = "Registered";
                        include('includes/header.inc.php');
                        include('views/registered.html');
                        include('includes/footer.inc.php');
                        
                    }else{
                        throw new Exception('Sorry, something went wrong. Please try again. <a href="login.php">go back</a>');
                    }
                    
                    
                }else{
                    throw new Exception('The username and/or email is already in our database. Please choose another. <a href="login.php>go back</a>"');
                }
                
            }else{
                throw new Exception('your password and password confirmation do not match. <a href="login.php">go back</a>');
            }
            
        }else{
            throw new Exception('Please enter valid information in to each input field. <a href="login.php">go back</a>');
        }
        
    }catch(Exception $e){
        $page_title = "Error";
        include('includes/header.inc.php');
        include('views/error.html');
        include('includes/footer.inc.php');
    }
}else{ //if page accessed in error - redirect to login page
    header('location:login.php');
    exit();
}

?>