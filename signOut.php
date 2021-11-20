<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are not correct')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $token = getBearerToken();
    $validator->validateToken($token);

    if($validator->error_validation == 0){
        
        $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];

        if ($ownerID) {

          $dbResult = $db->query('DELETE FROM owners_tokens WHERE token=:token', [':token'=>$token]);
          ($dbResult) ? printResult(json_encode("{'message': 'Logged out'}")) : errParmsUnvalid();

        }else{
          errTokenUnvalid();
        }//Token Auth
    }//validation check  
  }else{
    errServerAuth();
  }//Server Auth

?>