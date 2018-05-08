<?php

require('core/init.php');

if(isset($user)){
    $page_title = $user->getUsername();
    include('includes/header.inc.php');
    include('views/account.html');
    include('includes/footer.inc.php');
}else{
    header('location:index.php');
    exit();
}


?>