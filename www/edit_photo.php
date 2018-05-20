<?php

#this script confirms changes that administrator has made to individial titles and descriptions of photos
require('../core/init.php');

if( ($_SERVER['REQUEST_METHOD'] == "POST") && ( isset($user) && ($user->isAdmin()) ) ){
    
    $id = $_GET['id'];
    
    try{
        //validate post data
        $validate = new Validate();
        $title = $validate->isStrValid($_POST['title']);
        $desc = $validate->isStrValid($_POST['desc']);
        
        echo $title;
        
        //find current selected photo in database
        $q = "SELECT title, description FROM photos WHERE photo_id=:photo_id";
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':photo_id' => $id));

        if($r){ //if query executed successfully, update with new data
            $q = "UPDATE photos SET title=:title, description=:description WHERE photo_id=:photo_id";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':title' => $title, ':description' => $desc, ':photo_id' => $id));
            
            if($r){
                header('location:view.php?id='.$id);
            }else{
                throw new Exception('Sorry, something went wrong. Please try editing the photo again');
            }
            
            

        }else{
            throw new Exception('Sorry, we could not edit your photo due to server error. Please try again');
        }
        
        
    }catch(Exception $e){ //display errors if any
        $page_title = "Error";
        include('../includes/header.inc.php');
        include('../views/error.html');
        include('../includes/footer.inc.php');
        exit();
    }
    
    
    
}else{ //if page accessed in error, redirect user back to gallery
    header('location:gallery.php');
    exit();
}



?>