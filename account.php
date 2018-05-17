<?php

require('core/init.php');

if(isset($user) && ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) ){
    
    $page_title = $user->getUsername();
    include('includes/header.inc.php');
    include('views/account.html');
    include('includes/footer.inc.php');
    
}else{ //if page accessed in error - redirect to homepage
    header('location:index.php');
    exit();
}


?>