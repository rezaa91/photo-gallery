<?php

require('core/init.php');

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    //get photo id
    $id = $_GET['id'];
    
    try{
        //get the selected picture from the database
        $q  = 'SELECT * FROM photos WHERE photo_id=:id LIMIT 1';
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':id'=>$id));
        
        if($r){//if query successful
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $img = $stmt->fetch();
            
            echo "
            <div>
                <h1 class='header primary'>{$img['title']}</h1>
                <img src='{$img['file_path']}' />
                <p class='lead'>{$img['description']}</p>
            </div>
            ";
        
        }else{
            throw new Exception('Sorry, something went wrong. Please try again.');
        }
        
    }catch(Exception $e){
        $page_title = "Error";
        include('includes/header.inc.php');
        include('views/error.html');
        include('includes/footer.inc.php');
    }
    
}

?>