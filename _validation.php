<?php


class Validation{

    public $error_validation;

    public function __construct(){
        $this->error_validation = 0;
    }

    function ValidateRequired($data = array()){

        foreach($data as $key => $value){
            
            if( !isset($data[$key])){
                errParmsUnvalid($key . " is required");
                $this->error_validation = 1;
            } 
        } 
        
    }

    function validateText($key,$value){
        
        $value = $this->test_on_data($value);

        if(!preg_match ("/^[a-zA-Z-0-9_. ]*$/", $value) ){
            errParmsUnvalid($key . " must be string");
            $this->error_validation = 1;
        }else{
            return $value;
        }
        
    }
    function validateInteger($key,$value){
        
        $value = $this->test_on_data($value);

        if(!preg_match ("/^[0-9_ ]*$/", $value) ){
            errParmsUnvalid($key . " must be integer");
            $this->error_validation = 1;
        }else{
            return $value;
        }
        
    }
    
    function validateEmail($key,$value){

        $value = $this->test_on_data($value);
      
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
        if(!preg_match ($pattern, $value) ){
            errParmsUnvalid($key . " must be valid email");
            $this->error_validation = 1;
        }else{
            return $value;
        }
    }

    function validatePhone($key,$value){
     
       $value = $this->test_on_data($value);

        if(!preg_match ("/^[0-9]*$/", $value) ){
            errParmsUnvalid($key . " must be numeric");
            $this->error_validation = 1;
        }else{
            return $value;
        }
    }

    function validateDate($key,$value){

        $value = $this->test_on_data($value);
        
        if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value)){
            errParmsUnvalid($key . " must be format YYYY-MM-DD");
            $this->error_validation = 1;
        }else{
            return $value;
        }
    }

    function test_on_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    function validateToken($token){
        global $db;
        //token empty
        if(empty($token)){
            errParmsUnvalid("Token is required");
            $this->error_validation = 1;
            exit();
            
        }else{
            $owner = $db->query("SELECT * FROM owners_tokens WHERE token=:token", [":token"=>$token]);
            //Invalid token statu
            if(!$owner){
                errParmsUnvalid("Token is InValid");
                $this->error_validation = 1;
                exit();
            //token expired status    
            }else if($owner[0]['status'] == 0){
                $token = setOwnerToken($owner[0]['owner_id']);
                errParmsUnvalid("Token is Expired , "."new token: ".$token);
                // $this->error_validation = 1;
                exit();
            }
        }
        
        
        


    }
    
}



?>