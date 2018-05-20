<?php

require('../core/init.php');


if(isset($user) && ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) ){
    
    //set page title and insert header
    $page_title = "Add Administrator";
    include('../includes/header.inc.php');
    
    //get all administators
    try{
        $q = "SELECT CONCAT(first_name, ' ',last_name) AS full_name FROM users WHERE member_type=1";
        $r = $pdo->query($q);
        if($r){
            $r->setFetchMode(PDO::FETCH_ASSOC);
            
        }else{ //if unsuccessful query, throw exception
            throw new Exception('Sorry, something went wrong. Please try again.');
        }
        
    }catch(Exception $e){
        $page_title = "Error";
        include('../includes/header.inc.php');
        include('../views/error.html');
        include('../includes/footer.inc.php');
        exit();
    }
    
    
    
    //handle form if submitted
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        try{
            //validate data
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
                    $r2 = $pdo->query($q);

                    if($r2 && $r2->rowCount() == 0){ //if query ran ok and returned 0 records (i.e. no current user with inputted email or username - insert record in to database)
                        $q = "INSERT INTO users(email, username, first_name, last_name, pass, member_type, reg_date)VALUES(:email, :username, :first_name, :last_name, SHA1(:pass), 1, NOW())";
                        $stmt = $pdo->prepare($q);
                        $r2 = $stmt->execute(array(':email' => $email, ':username' => $username, ':first_name' => $first_name, ':last_name' => $last_name, ':pass' => $pass));

                        if($r2){ //if query ran ok - user inserted in to database. inform user
                            $success = "<p class='lead dark text-center'>Administrator has been added.</p>";
                        }else{
                            throw new Exception('Sorry, something went wrong. Please try again. <a href="admin.php">go back</a>');
                        }


                    }else{
                        throw new Exception('The username and/or email is already in our database. Please choose another. <a href="admin.php>go back</a>"');
                    }

                }else{
                    throw new Exception('your password and password confirmation do not match. <a href="admin.php">go back</a>');
                }

            }else{
                throw new Exception('Please enter valid information in to each input field. <a href="admin.php">go back</a>');
            }
            
        }catch(Exception $e){ //display errors if any
            $page_title = "Error";
            include('../views/error.html');
        }
        
    }//end of form handle IF
    
    
    //display page content and footer    
    include('../views/admin.html');
    include('../includes/footer.inc.php');
    
    
}else{ //redirect user to home page if page accessed in error
    header('location:index.php');
    exit();
}


?>