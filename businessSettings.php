<?php
  require_once("_config.php");
  header('Content-Type: application/json');
  
  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    
    $token = getBearerToken();
    $validator->validateToken($token);
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
    $settingsStatus = !isset($_GET['setting_status']) ? 'get' : $_GET['setting_status'];

    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $businessID = $db->query("SELECT id FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID])[0]['id'];

    if ($validator->error_validation == 0) {

      if ($settingsStatus == "add") { 

          $waitingQueue = $validator->validateInteger('waiting_queue',$_POST['waiting_queue']);
          $emailNotification = $validator->validateInteger('email_notifications',$_POST['email_notifications']);
          $capacity = $validator->validateInteger('capacity',$_POST['capacity']);
          $workCapacity = $validator->validateInteger('work_capacity',$_POST['work_capacity']);
          $serviceTime = $validator->validateInteger('service_time',$_POST['service_time']);
    
            $dbResult = $db->query("INSERT INTO business_settings (business_id,waiting_queue,email_notifications,capacity,work_capacity,service_time) VALUES (:business_id, :waiting_queue, :email_notifications, :capacity, :work_capacity, :service_time)", [":business_id"=>$businessID, ":waiting_queue"=>$waitingQueue, ":email_notifications"=>$emailNotification, ":capacity"=>$capacity, ":work_capacity"=>$workCapacity, ":service_time"=>$serviceTime]);
            
            
            if($db->query("SELECT business_id FROM business_settings WHERE business_id=:business_id",["business_id"=>$businessID])){
                
              successResponse("Business Settings Added Successfully");
              $businessStatus = $db->query("SELECT status FROM business WHERE id=:business_id", [":business_id"=>$businessID])[0]['status'];
              
              if ($businessStatus != BUSINESS_ACTIVE) {
                  $db->query("UPDATE business SET status=:status WHERE id=:business_id", [":status"=>BUSINESS_ACTIVE, ":business_id"=>$businessID]);
                }
            }else{
              failResponse();

             }
          
      }elseif($settingsStatus == "update"){

          $waitingQueue = $validator->validateInteger('waiting_queue',$_POST['waiting_queue']);
          $emailNotification = $validator->validateInteger('email_notifications',$_POST['email_notifications']);
          $capacity = $validator->validateInteger('capacity',$_POST['capacity']);
          $workCapacity = $validator->validateInteger('work_capacity',$_POST['work_capacity']);
          $serviceTime = $validator->validateInteger('service_time',$_POST['service_time']);

            $dbResult =  $db->query("UPDATE business_settings SET waiting_queue=:waiting_queue, email_notifications=:email_notifications, capacity=:capacity, work_capacity=:work_capacity, service_time=:service_time  WHERE business_id=:business_id", [":waiting_queue"=>$waitingQueue, ":waiting_queue"=>$waitingQueue, ":email_notifications"=>$emailNotification, ":capacity"=>$capacity, ":work_capacity"=>$workCapacity, ":service_time"=>$serviceTime, ":business_id"=>$businessID]);
            if($dbResult){
            successResponse("Updated Successfully");
            
          }else{
            failResponse();
           }

      }elseif($settingsStatus == "get"){

            $dbResult = $db->query("SELECT business_id,email_notifications, waiting_queue, capacity, work_capacity, service_time FROM business_settings WHERE business_id=:business_id", [":business_id"=>$businessID]);
          

          ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();
      }
  
    } //check validation

  }else{
    errorServerAuth();
  }//Server Auth

?>