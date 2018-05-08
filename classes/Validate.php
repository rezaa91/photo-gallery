<?php

class Validate{
    
    //returns string with no html tags
    function isStrValid($str){
        return htmlentities(trim($str));
    }
    
    //checks if valid email address - returns email if true
    function isEmailValid($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        }else{ //return false if invalid email address passed to method
            return false;
        }
    }
    
}

?>