<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $token = getBearerToken();
    $validator->validateToken($token);
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];


    $date =  !isset($_GET['date']) ? 'all' : $validator->test_on_data($_GET['date']);
    $rType = !isset($_GET['r_type']) ? 'all' : $validator->test_on_data($_GET['r_type']);
    $locationID = !isset($_GET['location_id']) ? 'all' : $validator->test_on_data($_GET['location_id']);
 
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $businessID = $db->query("SELECT id FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID])[0]['id']; 

    $dbResult = null;

    if ($validator->error_validation == 0) {
      if ($rType == "all") {
      
        if ($locationID == "all") {
 
          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id  WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status!=:status", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_CANCEL]);
        
        }else{
        
          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status!=:status AND location_id=:location_id", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_CANCEL, ":location_id"=>$locationID]);
        
        }//end locationID

        ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();


      }elseif ($rType == "cancel") {

        if ($locationID == "all") {

          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id  WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_CANCEL]);
        
        }else{

          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status AND location_id=:location_id", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_CANCEL, ":location_id"=>$locationID]);
        
        }

        ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();

      }elseif ($rType == "confirm") {
        
        if ($locationID == "all") {

          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id  WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_CONFIRM]);
        
        }else{

          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status AND location_id=:location_id", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_CONFIRM, ":location_id"=>$locationID]);
        
        }

        ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();

      }elseif ($rType == "waiting") {

       if ($locationID == "all") {

        $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id  WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_WAITING]);
        
        }else{

          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status AND location_id=:location_id", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_WAITING, ":location_id"=>$locationID]);
        
        }

        ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();

      }elseif ($rType == "history") {

         if ($locationID == "all") {

          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id  WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_HISTORY]);
        
        }else{

          $dbResult = $db->query("SELECT reservations.id as reservation_id, users.id as user_id, first_name, last_name, phone_number, reservations.status, reservations.created_at FROM reservations LEFT JOIN users ON reservations.user_id = users.id LEFT JOIN users_phones ON users.id = users_phones.user_id WHERE business_id=:business_id AND reservations.created_at > :timestamp_start AND reservations.created_at < :timestamp_end AND reservations.status=:status AND location_id=:location_id", [":business_id"=>$businessID, ":timestamp_start"=>$date, ":timestamp_end"=>$time->getNextFromDate(2, $date), ":status"=>R_HISTORY, ":location_id"=>$locationID]);
        
        }

        ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();

      }//History reservations

    }//check validation  
  }else{
    errServerAuth();
  }//Server Auth

?>