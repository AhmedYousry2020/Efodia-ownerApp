<?php
  require_once("_config.php");
  header('Content-Type: application/json');
 
  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

   
    
    $token = getBearerToken();
    $validator->validateToken($token);
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];

    $reservationID = !isset($_GET['reservation_id']) ? 'all' : $validator->test_on_data($_GET['reservation_id']);
    $date =  !isset($_GET['date']) ? '' : $validator->test_on_data($_GET['date']);
    
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $businessID = $db->query("SELECT id FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID])[0]['id'];
    
    if ($validator->error_validation == 0) {

      if ($reservationID == "all") {
        
        $dbResult = null;

        if (isset($_GET['location_id'])) {
          $locationID = $_GET['location_id'];
          $dbResult = $db->query("UPDATE reservations SET status=:status,updated_at=:updated_at WHERE business_id=:business_id AND location_id=:location_id AND created_at LIKE :timestamp", [":status"=>R_CONFIRM, ":business_id"=>$businessID, ":location_id"=>$locationID, ":timestamp"=>$date,":updated_at"=>$time->getNow()]);
          
        }else{
          $dbResult = $db->query("UPDATE reservations SET status=:status,updated_at=:updated_at WHERE business_id=:business_id AND created_at LIKE :timestamp", [":status"=>R_CONFIRM, ":business_id"=>$businessID, ":timestamp"=>$date,":updated_at"=>$time->getNow()]); 
        }
        
        ($dbResult) ? printResult(json_encode("{'message': 'All reservations confirmed'}")) : errParmsUnvalid();

      }else{
        
        $dbResult = $db->query("UPDATE reservations SET status=:status,updated_at=:updated_at WHERE id=:reservation_id", [":status"=>R_CONFIRM, ":reservation_id"=>$reservationID,":updated_at"=>$time->getNow()]);
        ($dbResult) ? printResult(json_encode("{'message': 'Reservation confirmed'}")) : errParmsUnvalid();
        
      }//end reservationID

   
    }//check validation
  }else{
    errServerAuth();
  }//Server Auth

?>