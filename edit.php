<?php

require('core/init.php');

//check if user is in session and if server request = get, and id is set
if(isset($user) && ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) ){
    
    //if page accessed via GET
    if($_SERVER['REQUEST_METHOD'] == "GET" && (isset($_GET['id'])) ){
        try{
        //get data from database
        $q = 'SELECT * FROM users WHERE id=:id';
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':id' => $_GET['id']));
        
        if($r){//if query executed correctly
            
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            
            //display page
            $page_title = "Edit";
            include('includes/header.inc.php');
            include('views/edit.html');
            include('includes/footer.inc.php');

        
        }else{
            throw new Exception('Sorry, something went wrong. Please try again');
        }
        
        
        }catch(Exception $e){
            $page_title = "Error";
            include('includes/header.inc.php');
            include('views/error.html');
            include('includes/footer.inc.php');
        }
        
        
    //if page accessed via form submission    
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        //validate inputted form data
        $validate = new Validate();
        
        $first_name = $validate->isStrValid($_POST['first_name']);
        $last_name = $validate->isStrValid($_POST['last_name']);
        $email = $validate->isEmailValid($_POST['email']);
        $pass = $validate->isStrValid($_POST['pass']);
        $confirm_pass = $validate->isStrValid($_POST['confirm_pass']);
        
        //change data that has been edited
        try{
            
            $success = null;
            
            //change password if data inputted and is equal to password confirmation
            if(!empty($pass) && !empty($confirm_pass)){ //if data has been inputted in to both fields (assume user is wanting to change password)
                if($pass == $confirm_pass){//if both fields are equal to each other, update database
                    $q = "UPDATE users SET pass=SHA1(:pass) WHERE username='{$user->getUsername()}'";
                    $stmt = $pdo->prepare($q);
                    $r = $stmt->execute(array(':pass' => $pass));

                    if($r){ //if query executed successfully, display success message to user                        
                        $success = "Password changed successfully";

                    }else{ //if problem with query
                        throw new Exception("Sorry, something went wrong. Please try again.");
                    }
                }else{
                    throw new Exception('Password and password confirmation do not match');
                }
            }
            
            //update first name, last name and email as long as fields arent empty
            if(!empty($first_name) && !empty($last_name) && !empty($email)){
                
                //update database with new information
                $q = "UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email WHERE username=:username";
                $stmt = $pdo->prepare($q);
                $r2 = $stmt->execute(array(':first_name' => $first_name, ':last_name'=>$last_name, ':email'=>$email, ':username'=>$user->getUsername()));
                
                if($r2){ //if query executed successfully, inform user that data has changed
                    
                    $success .= "<br />Your information has been updated."; //this message is displayed in browser
                    
                    //get updated information in order to display changes immediately to the user
                    $q = "SELECT * FROM users WHERE username=:username";
                    $stmt = $pdo->prepare($q);
                    $r = $stmt->execute(array(':username'=>$user->getUsername()));
                    
                    $stmt->setFetchMode(PDO::FETCH_CLASS,'Users'); //set fetch mode to Users class
                    $user = $stmt->fetch(); 
                    
                    $_SESSION['user'] = $user; //update the session with the updated user information for immediate effect
                    
                }else{
                    throw new Exception('Sorry, something went wrong. Please try again.');
                }
                
            }else{
                throw new Exception('There are empty fields in your form. Please fill the forms with the correct data.');
            }
            
            //get user information in order to display form with up to date data
            $q = "SELECT first_name, last_name, email FROM users WHERE username=:username";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':username' => $user->getUsername()));
            
            if($r){
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $row = $stmt->fetch();
                
                //display page
                $page_title = "Edit";
                include('includes/header.inc.php');
                include('views/edit.html');
                include('includes/footer.inc.php');
            }else{
                throw new Exception('Something went wrong. Please try again.');
            }
                
        }catch(Exception $e){
            $page_title = "Error";
            include('includes/header.inc.php');
            include('views/error.html');
            include('includes/footer.inc.php');
        }  
        
        
        
    }else{//redirect user if page accessed in error
        header('location:account.php');
        exit();
    }
    
    
    
    
    
    
        
}else{//redirect user if user not logged in
    header('location:index.php');
    exit();
}


?>