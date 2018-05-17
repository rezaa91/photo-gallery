<?php

require('core/init.php');

if(isset($user)){ //destroy the session
    $user = null;
    $_SESSION = array();
    setcookie('PHPSESSID');
    session_destroy();
    
    $page_title = "Logged out";
    include('includes/header.inc.php');
    include('views/logout.html');
    include('includes/footer.inc.php');
    
}else{ //redirect user if accessed in error
    header('location:index.php');
    exit();
}


?>