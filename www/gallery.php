<?php
require('../core/init.php');


try{
    
    //paginate query results
    $display = 18; // results to show per page
    
    //determine how many pages there have been
    if(isset($_GET['page']) && is_numeric($_GET['page'])){
        $pages = $_GET['page'];
    }else{ //count the number of records
        $q = "SELECT COUNT(photo_id) FROM photos";
        $r = $pdo->query($q);
        $r->setFetchMode(PDO::FETCH_BOTH);
        $records = $r->fetch(); 
        $records = $records[0]; //number of photos in database
        
        //calculate number of pages
        if($records > $display){//more than 1 page
            $pages = ceil($records/$display);
        }else{
            $pages = 1;
        }
    }
    
    //determine where in the database to start running results
    if(isset($_GET['start']) && is_numeric($_GET['start'])){
        $start = $_GET['start'];
    }else{
        $start = 0;
    }
    
    
    
    
    
    $q = "SELECT * FROM photos ORDER BY photo_id DESC LIMIT $start, $display" ; //get newest uploaded photo first
    $r = $pdo->query($q);
    
    if($r){//if query executed successfully
        
        $r->setFetchMode(PDO::FETCH_CLASS, 'Photos'); //set fetch mode
        
        //retrieve page
        $page_title = 'Gallery';
        include('../includes/header.inc.php');
        include('../views/gallery.html');
        include('../includes/footer.inc.php');
    
    }else{ //if error retrieving photos
        throw new Exception('Sorry, something went wrong. Please<a href="gallery.php">try again</a>.');
    }
    
    
}catch(Exception $e){
    display_errors_page($e);
    exit();
}


?>