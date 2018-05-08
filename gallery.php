<?php
require('core/init.php');


try{
    
    $q = 'SELECT * FROM photos ORDER BY upload_date DESC'; //get newest pic first
    $r = $pdo->query($q);
    
    if($r){//if query executed successfully
        
        $r->setFetchMode(PDO::FETCH_CLASS, 'Photos'); //set fetch mode
        
        //retrieve page
        $page_title = 'Gallery';
        include('includes/header.inc.php');
        include('views/gallery.html');
        include('includes/footer.inc.php');
    
    }else{
        throw new Exception('Sorry, something went wrong, please try again.');
    }
    
    
}catch(Exception $e){
    $page_title = "Errors";
    include('includes/header.inc.php');
    include('views/errors.html');
    include('includes/footer.inc.php');
}


?>