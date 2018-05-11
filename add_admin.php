<?php

require('core/init.php');

if(isset($user) && ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) ){
    
    
}else{ //redirect user to home page if accessed in error
    header('location:index.php');
    exit();
}


?>