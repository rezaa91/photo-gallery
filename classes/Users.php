<?php


class Users{
    protected $id = null;
    protected $email = null;
    protected $username = null;
    protected $first_name = null;
    protected $last_name = null;
    protected $pass = null;
    protected $member_type = null;
    protected $reg_date = null;
    
    //get id
    function getId(){
        return $this->id;
    }
    function getEmail(){
        return $this->email;
    }
    function getUsername(){
        return $this->username;
    }
    function getName(){
        return $this->first_name .' '.$this->last_name;
    }
    function isAdmin(){
        if($this->member_type == 1){
            return true;
        }else{
            return false;
        }
    }
    function getRegDate(){
        return $this->reg_date;
    }
}

?>