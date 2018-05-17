<?php

require('core/init.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    
    try{
        //validate data
        $form = new Validate();
    
        $email = $form->isEmailValid($_POST['email']);
        $pass = $form->isStrValid($_POST['pass']);
        
        //if valid data passed to form
        if($email && $pass){
            //check email and password combination against users database
            $q = 'SELECT * FROM users WHERE email=:email AND pass=SHA1(:pass)';
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':email' => $email, ':pass' => $pass));
            
            if($r && $stmt->rowCount() == 1){ //if only 1 record returned, redirect user to home page and store user details in session
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Users');
                $user = $stmt->fetch();
                
                $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']); //get the users OS and browser for security purposes
                $_SESSION['user'] = $user; //store the user information in a session for site navigation
                
                //redirect user
                header('location:index.php');
                exit();
                
            }else{
                throw new Exception('Your details are not recognised, please register. <a href="login.php">go back</a>');
            }
            
        }else{
            throw new Exception('Please fill the form in correctly <a href="login.php">go back</a>');
        }
        
    }catch(Exception $e){
        //if form filled incorrectly - display errors page and exit script
        $page_title = "Error!";
        include('includes/header.inc.php');
        include('views/error.html');
        include('includes/footer.inc.php');
        exit(); 
    }
    
    
}

$page_title = "Login";
include('includes/header.inc.php');
include('views/login.html'); //include the form
include('includes/footer.inc.php');


?>