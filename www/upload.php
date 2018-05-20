<?php

require('../core/init.php');

if( (isset($user) && $user->isAdmin() ) && ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) ){ 
    
    //display header
    include('../includes/header.inc.php');
    
    //if form submitted - then add picture to database
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        try{
            
            //validate data
            $validate = new Validate();
            
            $title = $validate->isStrValid($_POST['title']);
            $description = $validate->isStrValid($_POST['description']);
            
            if($title && $description){
                
                //upload image and insert data in to database
                $name = $_FILES['file']['name']; //get file name from user side
                $temp_name = $_FILES['file']['tmp_name']; //get temp name from server
                $file_type = $_FILES['file']['type']; //get mimetype of uploaded file
                $allowed_types = ['image/jpeg','image/gif', 'image/png']; //only extensions allowed

                if(isset($name)){
                    
                    //if file type is not an image file (e.g. jpg), alert user and throw exception
                    if(!in_array($file_type, $allowed_types)){
                        throw new Exception('Please upload image files only');
                    }
                    
                    if(!empty($name)){
                        $location = '../uploads/'; //directory
                        if(move_uploaded_file($temp_name, $location.$name)){ //move file to uploads directory
                            $success = "File uploaded successfully, <a href='gallery.php'>view in gallery</a>";
                        }else{
                            throw new Exception('Files must be smaller than 2MB.');
                        }
                    }else{
                        throw new Exception('Sorry, something went wrong. Please try again.');
                    }
                    
                    $file_path = $location.$name; //get file path
                    
                    //insert photo information in to database
                    $q = "INSERT INTO photos(user_id, title, description, file_path, upload_date) VALUES(:user_id, :title, :description, :file_path, NOW())";
                    
                    $stmt = $pdo->prepare($q);
                    $r = $stmt->execute(array(':user_id'=>$user->getId(), ':title' => $title, ':description' => $description, ':file_path' => $file_path ));
                    
                    if(!$r){ //if query executed unsuccessfully
                        throw new Exception('Sorry, something went wrong. Please try again');
                    }
                    
                    
                }else{
                    throw new Exception("Please select a file to upload");
                }
                
            }else{
                throw new Exception('Please fill in all the fields before uploading your image');
            }

            
            
        }catch(Exception $e){
            $page_title = 'Error';
            include('../views/error.html');
        }

    }
    
    //display footer and content
    include('../views/upload.html');
    include('../includes/footer.inc.php');
    
    
}else{ //redirect user to home page if accessed in error
    header('location:index.php');
    exit();
}


?>