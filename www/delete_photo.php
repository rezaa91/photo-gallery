<?php

#this script deletes a photo from the database and removed it from the uploads/ dir

require('../core/init.php');

//only administrators can delete photos
if($_SERVER['REQUEST_METHOD'] == "GET" && ( isset($user) && $user->isAdmin() ) ){
    
    //get photo id
    $order_id = $_GET['id'];
    
    try{
        
    
        //select photo to delete, and then remove from database
        $q = "SELECT photo_id, file_path, order_id FROM photos WHERE order_id=:order_id LIMIT 1";
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':order_id' => $order_id));
        
        if($r){//if query executed successfully, delete photo
            
            //get file path
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $photo = $stmt->fetch();
            $photo_id = $photo['photo_id']; //get photo id, to be used in query below which adjusts order_id to be aligned with no gaps 
            $file_path = $photo['file_path']; //get file path to the photo in the uploads/ dir
            $order_id = $photo['order_id']; //get the order_id value
            
            
            
            //adjust all values in the order_id column in mysql, that came after the deleted photo, minus 1. So no gaps in order
            $q2 = "UPDATE photos SET order_id = (order_id - 1) WHERE photo_id > :photo_id";
            $stmt2 = $pdo->prepare($q2);
            $r2 = $stmt2->execute(array(':photo_id' => $photo_id));
            
            
            
            //delete photo from database
            $q = "DELETE FROM photos WHERE photo_id=:photo_id LIMIT 1";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':photo_id' => $photo_id));
            
            
            
            
            
            if($r && $r2){ //if photo removed from database, and the order_id of all other rows have been changed, then remove from folder and redirect user to gallery - i.e. photo deleted successfully

                //delete photo from uploads dir
                unlink($file_path);
                
                //redirect user to next picture along, if not the last image
                if( ($order_id - 1) != 0 ){
                    header('location:view.php?id='. ($order_id - 1));
                }else{ //redirect to gallery.php if the last image is deleted
                    header('location:gallery.php');
                }
                
            
            }else{//if problem with removing photo from database, throw error
                throw new Exception('Sorry, something went wrong. Please<a href="view.php?id='.$order_id.'">try again.</a>');
            }
            
        
        }else{ //throw error if problem with query
            throw new Exception('Sorry, something went wrong. Please<a href="view.php?id='.$order_id.'">try again.</a>');
        }
        
        
    }catch(Exception $e){ //display error page
        display_errors_page($e); //display error page
        exit();
    }
    
    
    
}else{ //redirect user to gallery if accessed in error
    header('location:gallery.php');
    exit();
}