<?php 
  require_once("_config.php");
  header('Content-Type: application/json');
  
  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are not correct')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER  &&  $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
    
    $validator->ValidateRequired($_POST);
    
    $email = $validator->validateEmail('email',$_POST['email']);
    $Resetcode = $_POST['reset-code'];
    $newPassword = $validator->test_on_data($_POST['new_password']);

    if($validator->error_validation == 0){
      
        if($db->query('SELECT email FROM owners WHERE email=:email', [':email'=>$email])){
                
            $code = $db->query('SELECT code FROM owners_password_resets WHERE email=:email',[":email"=>$email])[0]['code'];
            
            if($code == $Resetcode){
           
            $db->query("UPDATE owners SET password=:password WHERE email=:email",["password"=>password_hash($newPassword, PASSWORD_DEFAULT),"email"=>$email]);
            
                successResponse("Password has been updated");
            }else{
                errParmsUnvalid();
        
            }
        }else{
            errParmsUnvalid();
    
        }        
    }//check validation
    
    
      
      
  }else{
     errServerAuth();
  }//Server Auth
?>