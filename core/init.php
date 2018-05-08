<?php

//load classes automatically when used
function class_loader($class){
    require('classes/' . $class . '.php');
}

spl_autoload_register('class_loader');


//begin the session
session_start();

//check for a user in the session - and check against the users OS and browser when first logged in
if(isset($_SESSION['user']) && (isset($_SESSION['agent']) && $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) ){
    $user = $_SESSION['user'];
}


//connect to database
try{
    
    $pdo = new PDO('mysql:dbname=gallery; host=localhost', 'root','');
    
}catch(PDOException $e){ //if error connecting to database, inform user
    $page_title = 'Error!';
    include('includes/header.inc.php');
    include('views/error.html');
    include('includes/footer.inc.php');
    exit();
    
}


?>