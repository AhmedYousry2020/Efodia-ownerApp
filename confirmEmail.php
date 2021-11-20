<?php

  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
    
    $token = getBearerToken();
    $validator->validateToken($token);
    $validator->ValidateRequired($_POST);
    
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $Activatecode = $_POST['activate-code'];
    
    if($validator->error_validation == 0){
      
    $code = $db->query('SELECT code FROM owners_confirm WHERE id=:owner_id',[":owner_id"=>$ownerID])[0]['code'];
    if($Activatecode == $code){
        successResponse("Confirmed Email Successfully");  

    }else{
        errParmsUnvalid();

    }    
    }//check validation
  }else{
    errServerAuth();
  }//Server Auth     


?>