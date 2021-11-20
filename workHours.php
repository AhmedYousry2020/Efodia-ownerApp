<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $token = getBearerToken();
    $validator->validateToken($token);

    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
    $status = !isset($_GET['status']) ? 'get' : $_GET['status'];

    $locationID = null;
    $cardID = null;
    
    
    $validator->ValidateRequired($_POST);

    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $businessID = $db->query("SELECT id FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID])[0]['id'];

    if ($validator->error_validation == 0) {

      if ($status == "add") { 
  
        $locationId = $validator->validateInteger('location_id',$_POST['location_id']);
        $startHour = $validator->test_on_data($_POST['start_hour']);
        $endHour = $validator->test_on_data($_POST['end_hour']);
        $su =  $validator->validateInteger('su',$_POST['su']);
        $mo = $validator->validateInteger('mo',$_POST['mo']);
        $tu = $validator->validateInteger('tu',$_POST['tu']);
        $we = $validator->validateInteger('we',$_POST['we']);
        $th = $validator->validateInteger('th',$_POST['th']);
        $fr = $validator->validateInteger('fr',$_POST['fr']);
        $sa = $validator->validateInteger('sa',$_POST['sa']);
      
        $timeCardID  = $db->query("INSERT INTO business_time_cards (business_id,location_id,position,created_at,updated_at) VALUES (:business_id, :location_id,:position,:created_at,:updated_at)", [":business_id"=>$businessID, ":location_id"=>$locationId,":position"=>1,":created_at"=>$time->getNow(),":updated_at"=>$time->getNow()]);  
        
        if($timeCardID){
            $dbResult = $db->query("INSERT INTO business_work_hours (time_card_id,start_hour,end_hour,su,mo,tu,we,th,fr,sa,created_at,updated_at) VALUES (:time_card_id, :start_hour, :end_hour, :su, :mo, :tu, :we, :th, :fr, :sa,:created_at,:updated_at)", [":time_card_id"=>$timeCardID, ":start_hour"=>$startHour, ":end_hour"=>$endHour, ":su"=>$su, ":mo"=>$mo, ":tu"=>$tu, ":we"=>$we, ":th"=>$th, ":fr"=>$fr, ":sa"=>$sa,":created_at"=>$time->getNow(),":updated_at"=>$time->getNow()]);
            if ($dbResult){
              successResponse("Time Cart Added Sucessfully");
              $businessStatus = $db->query("SELECT status FROM business WHERE id=:business_id", [":business_id"=>$businessID])[0]['status'];

              if ($businessStatus != BUSINESS_ACTIVE) {
                  $db->query("UPDATE business SET status=:status WHERE id=:business_id", [":status"=>BUSINESS_HOURS, ":business_id"=>$businessID]);
              }
              
            }else{
              failResponse();
            }
   
        }else{
            errParmsUnvalid();
        }  

      }elseif ($status == "delete") {
          $timeCardId = !isset($_GET['time_card_id']) ? '' : $_GET['time_card_id'];
          $timeCardID = $db->query('SELECT id FROM business_time_cards WHERE id=:time_card_id',[":time_card_id"=>$timeCardId]);
          if($timeCardID){ 
            $timeCardID = $timeCardID[0]['id']; 
          $dbResult = $db->query("DELETE FROM business_time_cards WHERE id=:time_card_id", [":time_card_id"=>$timeCardID]);
          
          ($dbResult) ? printResult(json_encode("{'message': 'Time card deleted successfully'}")) : errParmsUnvalid();
          }else{
            errParmsUnvalid();
          }

      }elseif ($status == "get") {
      
        $locationId = !isset($_GET['location_id']) ? '' : $_GET['location_id'];
        $locationID = $db->query("SELECT id FROM business_locations WHERE id=:location_id AND business_id = :business_id AND status=:status", [":location_id"=>$locationId,":business_id"=>$businessID, ":status"=>STATUS_ACTIVE]);
        if($locationID){
          $locationID = $locationID[0]['id'];
          
          $cards = $db->query("SELECT id as card_id FROM business_time_cards WHERE location_id=:location_id AND  business_id = :business_id", [ ":location_id"=>$locationID,":business_id"=>$businessID]);
          
          $cardsArray = ['cards'=>[]];
          foreach ($cards as $cardKey => $cardValue) {
            $workHours = $db->query("SELECT id, start_hour, end_hour, su, mo, tu, we, th, fr, sa FROM business_work_hours WHERE time_card_id=:time_card_id", [":time_card_id"=>$cardValue['card_id']]);
            $card['card_id'] = $cardValue['card_id'];
            $card['work_hours'] = $workHours;
            array_push($cardsArray['cards'], $card); 
          }
        }   
        //$locations = $db->query("SELECT time_cards.location_id, owners_locations.location_name FROM time_cards LEFT JOIN owners_locations ON owners_locations.location_id=time_cards.location_id WHERE time_cards.owner_id=:owner_id GROUP BY location_id", [":owner_id"=>$ownerID]);
        
        // $locationsArray = ['locations'=>[]];

        // foreach ($locations as $locationKey => $locationValue) {
        //   $cards = $db->query("SELECT time_card_id as card_id FROM time_cards WHERE owner_id=:owner_id AND location_id=:location_id", [":owner_id"=>$ownerID, ":location_id"=>$locationValue['location_id']]);
          
        //   foreach ($cards as $cardKey => $cardValue) {
        //     $workHours = $db->query("SELECT time_id, start_hour, end_hour, su, mo, tu, we, th, fr, sa FROM work_hours WHERE time_card_id=:time_card_id", [":time_card_id"=>$cardValue['card_id']]);
        //     $card['card_id'] = $cardValue['card_id'];
        //     $card['work_hours'] = $workHours;
        //     array_push($cardsArray['cards'], $card); 
        //   }
          
        //   $location['location_id'] = $locationValue['location_id'];
        //   $location['location_name'] = $locationValue['location_name'];
        //   array_push($locationsArray['locations'], array_merge($location, $cardsArray));
        ($cardsArray) ? printResult(json_encode($cardsArray)) :errParmsUnvalid();
    
      }else{
        errParmsUnvalid("Status error");
      }

    } //check validation

  }else{
    errorServerAuth();
  }//Server Auth

?>