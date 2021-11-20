<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $token = getBearerToken();
    $validator->validateToken($token);
 
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
  

   if ($validator->error_validation == 0) {

      $dbResult = $db->query("SELECT status FROM owners WHERE id=:owner_id", [":owner_id"=>$ownerID]);
      printResult(json_encode($dbResult));

    }//check valiidtion
  }else{
    errorServerAuth();
  }//Server Auth

?>