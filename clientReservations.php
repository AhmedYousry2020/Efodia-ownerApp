<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $token = getBearerToken();
    $validator->validateToken($token);
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];

    $userID = !isset($_GET['user_id']) ? '' : $validator->test_on_data($_GET['user_id']);
    
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $businessID = $db->query("SELECT id FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID])[0]['id']; 
    
    if ($validator->error_validation == 0) {
      $reservations = $db->query("SELECT reservations.id, reservations.business_id, reservations.location_id, reservations.user_id, users.first_name, users.last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id =users.id LEFT JOIN users_phones ON users.id = users_phones.user_id WHERE reservations.business_id =:business_id AND users.id=:user_id", [":user_id"=>$userID,":business_id"=>$businessID ]); 

      ($reservations) ? printResult(json_encode($reservations)) : errNoData();

    }//check validation
  }else{
    errServerAuth();
  }//Server Auth

?>