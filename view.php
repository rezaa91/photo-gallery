<?php

require('core/init.php');

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
            
            //display page
            $page_title = $img['title'];
            include('includes/header.inc.php');
            
            
            //show image on screen
            echo "
            <div class='offset page-layout bottom-spacing'>";
            
            //show next and previous buttons
            if($id > 1){ //give page a previous button if not the first image
                $previous = $id-1;
                echo "<a href='view.php?id={$previous}'>Previous</a>"; //go to previous image
            }
            
            if($id < $count){ //if current pic is not the last image in the database, show next button
                $next = $id+1;
                echo "<a href='view.php?id={$next}'>Next</a>"; //go to next image
            }
            
            //finish markup for page
            echo "<h1 class='sub-header primary text-center'>{$img['title']}</h1>
                <img src='{$img['file_path']}' />
                <p class='lead text-center'>{$img['description']}</p>
            </div>
            ";
            
        
            include('includes/footer.inc.php');
            
        }else{
            throw new Exception('Sorry, something went wrong. Please try again.');
        }
        
    }catch(Exception $e){
        $page_title = "Error";
        include('includes/header.inc.php');
        include('views/error.html');
        include('includes/footer.inc.php');
    }
    
}else{//if page accessed in error - redirect to home page
    header('location:index.php');
}

?>