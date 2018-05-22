<?php

#This script shows the homepage
## Uses MySQL to access the 3 most recent uploads

require('../core/init.php');


try{
    $q = 'SELECT * FROM photos ORDER BY order_id DESC LIMIT 3';
    $r = $pdo->query($q);
    
    if($r){ //if query ran ok, display home page
        $r->setFetchMode(PDO::FETCH_CLASS,'Photos'); //set fetch mode to Photos class
        
        //include header, view and footer
        $page_title = "Homepage"; //set page title
        include('../includes/header.inc.php');
        include('../views/index.html');
        include('../includes/footer.inc.php');
    }else{ //if error with query, throw new exception to inform user on error page
        throw new Exception('Sorry, something went wrong. Please<a href="index.php">try again</a>');
    }
    
    
    
}catch(Exception $e){
    display_errors_page($e);
    exit();
}



?>