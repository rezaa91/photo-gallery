<?php

require('../core/init.php');

if($_SERVER['REQUEST_METHOD'] == "GET" && (isset($_GET['id'])) ){
    
    //get photo id
    $id = $_GET['id'];
    
    try{
        
        //get total number of photos in database
        $q = "SELECT (photo_id) AS total_photos FROM photos";
        $r = $pdo->prepare($q);
        $r->execute();
        
        $count = $r->rowCount(); //total number of photos in database
        
        
        //get the selected picture from the database
        $q  = 'SELECT * FROM photos WHERE photo_id=:id LIMIT 1';
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':id'=>$id));
        
        if($r){//if query successful            
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $img = $stmt->fetch();
            
            
            //throw exception if false id passed in to url
            if(!$img){
                throw new Exception('Oops, this page does not exist. <a href="gallery.php">Go back</a>');
            }
            
            
            
            //display page - with the functionality of users being able to comment
            $q = "SELECT u.id, u.username AS username,p.post_id, p.user_id, p.pic_comment AS comment, p.date_posted AS date_posted, ph.photo_id AS photo_id FROM users AS u INNER JOIN posts AS p ON u.id = p.user_id INNER JOIN photos AS ph ON ph.photo_id = p.photo_id WHERE ph.photo_id = :photo_id ORDER BY p.date_posted"; //this query selects the user who posted the comment, including the comment in order to display on page
            
            
            $stmt2 = $pdo->prepare($q);
            $r2 = $stmt2->execute(array(':photo_id' => $id)); //get post for current display image
            
            $stmt2->setFetchMode(PDO::FETCH_ASSOC);
            
            
            //display page
            $page_title = $img['title'];
            include('../includes/header.inc.php');
            include('../views/view.html');       
            include('../includes/footer.inc.php');
            
        }else{
            throw new Exception('Sorry, something went wrong. Please try again.');
        }
        
    }catch(Exception $e){
        $page_title = "Error";
        include('../includes/header.inc.php');
        include('../views/error.html');
        include('../includes/footer.inc.php');
        exit();
    }
    
    
}elseif($_SERVER['REQUEST_METHOD'] == "POST"){ //handle post comment form submission
    
    $id = $_GET['id'];
    
    try{
        //validate comment data
        $validate = new Validate();

        $comment = $validate->isStrValid($_POST['comment']);

        if($comment){//if valid comment - add to database and then redirect user
            $q = "INSERT INTO posts(user_id, photo_id, pic_comment, date_posted) VALUES(:user_id, :photo_id, :comment, NOW())";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute(array(':user_id' => $user->getId(), ':photo_id' => $id, ':comment'=>$comment));
            
            if($r){//if comment successfully inserted into database
                
                header("location:view.php?id=$id"); //redirect user
                
            }else{ //inform user of error if query unsuccessful
                throw new Exception("Sorry, something went wrong. Please <a href='view.php?id=$id'>try again</a>.");
            }
        
        }else{
            throw new Exception("Please enter a comment. <a href='view.php?id=$id'>Go back</a>");
        }
    }catch(Exception $e){
        $page_title = "Error";
        include('../includes/header.inc.php');
        include('../views/error.html');
        include('../includes/footer.inc.php');
        exit();
    }   
    
    
    
}else{//if page accessed in error - redirect to home page
    header('location:index.php');
    exit();
}


?>