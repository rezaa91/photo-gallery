<?php

#this script confirms changes that administrator has made to individial titles and descriptions of photos
require('../core/init.php');

if( ($_SERVER['REQUEST_METHOD'] == "POST") && ( isset($user) && ($user->isAdmin()) ) ){
    
    $id = $_GET['id']; //this is the order_id of the selected photo
    
    try{
        //validate post data
        $validate = new Validate();
        $title = $validate->isStrValid($_POST['title']); //validate title
        $desc = $validate->isStrValid($_POST['desc']); //validate description
        
        //find current selected photo in database
        $q = "SELECT title, description FROM photos WHERE photo_id=:photo_id";
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':photo_id' => $id));

        if($r){ //if query executed successfully, update with new data
            $q = "UPDATE photos SET title=:title, description=:description WHERE order_id=:order_id";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':title' => $title, ':description' => $desc, ':order_id' => $id));
            
            if($r){
                header('location:view.php?id='.$id);
                exit();
            }else{
                throw new Exception('Sorry, something went wrong. Please<a href="view.php?id='.$id.'">try again.</a>');
            }
            
            

        }else{ //if error with database finding photo
            throw new Exception('Sorry, we could not edit your photo due to server error. Please<a href="view.php?id='.$id.'">try again.</a>');
        }
        
        
    }catch(Exception $e){ //display errors if any
        display_errors_page($e);
        exit();
    }
    
    
    
}else{ //if page accessed in error, redirect user back to gallery
    header('location:gallery.php');
    exit();
}



?>