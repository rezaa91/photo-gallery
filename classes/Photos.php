<?php

class Photos{
    protected $photo_id = null;
    protected $user_id = null;
    protected $title = null;
    protected $description = null;
    protected $file_path = null;
    protected $upload_date = null;
    
    //get properties
    function getPhotoId(){
        return $this->photo_id;
    }
    function getUserId(){
        return $this->user_id;
    }
    function getTitle(){
        return $this->title;
    }
    function getDescription(){
        return $this->description;
    }
    function getFilePath(){
        return $this->file_path;
    }
    function getUploadDate(){
        return $this->upload_date;
    }
}

?>