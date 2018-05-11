<?php

require('core/init.php');

if(isset($user) && $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])){
    
    try{
    
        //delete user from database
        if($user->isAdmin()){
            //check if last administrator before allowing to delete account
            
            

        }else{
            //delete account
            $q = "DELETE FROM users WHERE id=:id";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':id' => $user->getId()));

            if($r){ //inform user that account has been deleted, log user out and remove session
                $user = null;
                $_SESSION = array();
                setcookie('PHPSESSID');
                session_destroy();
                
                $page_title = "Deleted";
                include('includes/header.inc.php');
                include('views/deleted.html');
                include('includes/footer.inc.php');

            }else{//throw new exception if error with query
                throw new Exception('Sorry, something went wrong. We could not delete you from our records, please try again.');
            }
        }
        
    }catch(Exception $e){
        $page_title = 'Error';
        include('includes/header.inc.php');
        include('views/error.html');
        include('includes/footer.inc.php');
    }
    
    
}else{//redirect user if accessed in error
    header('location:index.php');
    exit();
}

?>