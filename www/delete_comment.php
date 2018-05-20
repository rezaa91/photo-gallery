<?php

#this script allows administrators and users who commented to delete (their) comments

require('../core/init.php');

if(isset($user) && $_SERVER['REQUEST_METHOD'] == "GET"){
    
    try{
        //store post id and photo id in var
        $photo_id = $_GET['id'];
        $post_id = $_GET['post_id'];
        
        //before allowing to delete, make sure user is admin or if not, make sure user is the one who posted the comment
        //select the post which was selected on view.html
        $q = "SELECT post_id, user_id, photo_id FROM posts WHERE post_id = :post_id && user_id = :user_id && photo_id = :photo_id LIMIT 1";
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array( ':post_id'=>$post_id, ':user_id'=>$user->getId(), ':photo_id'=>$photo_id ));
        
        if($r){
            //delete comment from database
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $post = $stmt->fetch();
            $post_id = $post['post_id']; //get post_id from SELECT query above
            
            //delete post from database, and redirect user back to page
            $q = "DELETE FROM posts WHERE post_id=:post_id";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':post_id'=>$post_id));
            
            if($r){ //redirect user back to view page if deleted successfull
                header('location:view.php?id='.$photo_id);
                
                
            }else{//if error with query, inform user
                throw new Exception('Sorry, we could not delete the comment, please try again.');
            }
            
            
            
        }else{ //if error with finding the selected post
            throw new Exception('Sorry, we could not delete the comment, please try again.');
        }
        
        
        
        
        
    }catch(Exception $e){
        $page_title = "Error!";
        include('../includes/header.inc.php');
        include('../views/error.html');
        include('../includes/footer.inc.php');
        exit();
    }
    
    
}else{ //redirect to gallery if page accessed in error
    
    header('location:gallery.php');
    exit();
}


?>