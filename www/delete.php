<?php

require('../core/init.php');

if(isset($user) && $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])){
    
    try{
    
        //delete administrator from database - as long as administrator isn't the last remaining administrator
        if($user->isAdmin()){
            //check if last administrator before allowing to delete account
            $q = "SELECT id FROM users WHERE member_type=1";
            $r = $pdo->query($q);
            
            if($r && $r->rowCount()>1){ //if user is not the last administrator, then delete account
                $q = "DELETE FROM users WHERE id=:id";
                $stmt = $pdo->prepare($q);
                $r = $stmt->execute(array(':id'=>$user->getId()));
                
                if($r){
                    $user = null;
                    $_SESSION = array();
                    setcookie('PHPSESSID');
                    session_destroy();
                    
                    $page_title = "Deleted";
                    include('../includes/header.inc.php');
                    include('../views/deleted.html');
                    include('../includes/footer.inc.php');
                    
                }else{ //if unable to delete user due to system error
                    throw new Exception('Sorry, something went wrong. Please<a href="admin.php">try again</a>.');
                }
                
            }else{ //If there is only one administrator, inform user there must be at least one
                throw new Exception('There must be at least 1 administrator.<a href="admin.php">Go back.</a>');
            }
        
            

        }else{ //if user is not an administrator - delete their standard account
            
            //delete account
            $q = "DELTE FROM users WHERE id=:id";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':id' => $user->getId()));

            if($r){ //inform user that account has been deleted, log user out and remove session
                $user = null;
                $_SESSION = array();
                setcookie('PHPSESSID');
                session_destroy();
                
                $page_title = "Deleted";
                include('../includes/header.inc.php');
                include('../views/deleted.html');
                include('../includes/footer.inc.php');

            }else{//throw new exception if error with query
                throw new Exception('Sorry, something went wrong. We could not delete you from our records, please<a href="edit.php?id='.$user->getId().'">try again.</a>'); //send back to edit page
            }
        }
        
    }catch(Exception $e){
        display_errors_page($e); //display error page
        exit();
    }
    
    
}else{//redirect user if accessed in error
    header('location:index.php');
    exit();
}

?>