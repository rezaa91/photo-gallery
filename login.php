<?php

require('core/init.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    //validate data
    
    //check data against database
    
    //log user in or display errors
    
}

$page_title = "Login";
include('includes/header.inc.php');
include('views/login.html'); //include the form
include('includes/footer.inc.php');


?>