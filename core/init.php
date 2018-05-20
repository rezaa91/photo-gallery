<?php

//load classes automatically when used
function class_loader($class){
    require('../classes/' . $class . '.php');
}

spl_autoload_register('class_loader');


//begin the session
session_start();

//check for a user in the session - and check against the users OS and browser when first logged in
if(isset($_SESSION['user']) && (isset($_SESSION['agent']) && $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) ){
    $user = $_SESSION['user'];
}


//config file to store database data
$_CONFIG = [
    'server' => [
        'host' => 'db738551371.db.1and1.com',
        'port' => 3306,
        'username' => 'dbo738551371',
        'password' => 'Issaee50!',
        'db_name' => 'db738551371'
    ],
    'local_server' => [
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'Issaee50!',
        'db_name' => 'gallery'
    ]
];


//comment the below code out on localhost
/*
error_reporting(0);
ini_set('display_errors',0);
*/




//connect to database
try{
    
    $pdo = new PDO('mysql:host=' . $_CONFIG['local_server']['host'] . /*';port=' . $_CONFIG['server']['port'] .*/ ';dbname=' . $_CONFIG['local_server']['db_name'], $_CONFIG['local_server']['username'], $_CONFIG['local_server']['password']);
    
}catch(PDOException $e){ //if error connecting to database, inform user
    $page_title = 'Error!';
    include('includes/header.inc.php');
    include('views/error.html');
    include('includes/footer.inc.php');
    exit();
    
}


?>