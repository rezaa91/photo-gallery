<?php

#this script deletes a photo from the database and folder

require('../core/init.php');

//only administrators can delete photos
if($_SERVER['REQUEST_METHOD'] == "GET" && ( isset($user) && $user->isAdmin() ) ){
    
    //get photo id
    $photo_id = $_GET['id'];
    
    try{
        
    
        //select photo to delete, and then remove from database
        $q = "SELECT photo_id, file_path FROM photos WHERE photo_id=:photo_id LIMIT 1";
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':photo_id' => $photo_id));
        
        if($r){//if query executed successfully, delete photo
            
            //get file path
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $photo = $stmt->fetch();
            $file_path = $photo['file_path'];
            
            $q = "DELETE FROM photos WHERE photo_id=:photo_id LIMIT 1";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':photo_id' => $photo_id));
            
            if($r){ //if photo removed from database, remove from folder and redirect user to gallery
                
                //delete photo from uploads dir
                unlink($file_path);
                
                //redirect user to gallery
                header('location:gallery.php');
            
            }else{//if problem with database, throw error
                throw new Exception('Sorry, something went wrong. Please try again.');
            }
            
        
        }else{ //throw error if problem with query
            throw new Exception('Sorry, something went wrong. Please try again.');
        }
        
        
    }catch(Exception $e){ //display error page
        $page_title = "Error!";
        include('../includes/header.inc.php');
        include('../views/error.html');
        include('../includes/footer.inc.php');
        exit();
    }
    
    
    
}else{ //redirect user to gallery if accessed in error
    header('location:gallery.php');
    exit();
}