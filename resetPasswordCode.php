<?php 
  require_once("_config.php");
  header('Content-Type: application/json');
  
  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are not correct')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER  &&  $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
      
    $validator->ValidateRequired($_POST);
    
    $email = $validator->validateEmail('email',$_POST['email']);
    
    if($validator->error_validation == 0){
      
        if($db->query('SELECT email FROM owners WHERE email=:email', [':email'=>$email])){
            
            $dbResult = $db->query('SELECT id,first_name,last_name FROM owners WHERE email=:email', [':email'=>$email]);
            
            $firstName = $dbResult[0]['first_name'];
            $lastName = $dbResult[0]['last_name'];
            $ownerID = $dbResult[0]['id'];
            
            sendOwnerResetPasswordCode($ownerID, $email, $firstName, $lastName);
            successResponse("Send Reset Code to Your Email");
        }else{
            errParmsUnvalid();
    
        }    
    }//check validation
    
    
      
      
  }else{
     errServerAuth();
  }//Server Auth
?>