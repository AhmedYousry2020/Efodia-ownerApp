<?php
  require_once("_config.php");

 // $db->query("UPDATE owners SET pw=:pw WHERE owner_id='6f2486e26206cb01e591",[":pw"=>password_hash("Aa@123", PASSWORD_DEFAULT)]);

  //INSDERT TO buisness_time_cards **************************************************************************
	
    //     for($i =42; $i < 10043; $i++){
    // 	 $card_timeID = null;
    // 	 $business_id = null;
    // 	 $location_id = null;
    	 
    // 	   	do {
    // 		   $card_timeID = $generator->generateCardTimeID();
    // 		   $dbResult = $db->query('SELECT id FROM business_time_cards WHERE id=:id', [':id'=>$card_timeID]);
    // 		} while($dbResult);
    		
    	
    // 		   $location_id = $i;
    // 		   $business_id = $db->query('SELECT business_id FROM business_locations WHERE id=:location_id', [':location_id'=>$location_id]);	
    		   
    // 	     if($business_id){
    // 	         $position = $generator->generatePosition();
    // 		   $created_at = $generator->generateCreatedAt();
    // 		   $updated_at = $generator->generateUpdatedAt();
    		
    			
    // 		$dbResult = $db->query("INSERT INTO business_time_cards VALUES (:id, :business_id, :location_id, :position, :created_at ,:updated_at)", [":id"=>$card_timeID,   ":business_id"=>$business_id[0]['business_id'], ":location_id"=>$location_id, ":position"=>$position, ":created_at"=>$created_at, ":updated_at"=>$updated_at]);
    		  	
    //           echo $i . " -- ";
    // 	     }
    
    //     }

 //INSDERT TO buisness_work_hours ***************************************************************************
    // 	for($i = 50; $i < 10051; $i++){
    // 	 $work_TimeID = null;
    // 	 $card_timeID = null;
    	 
    // 	    do {
    // 		   $work_TimeID = $generator->generateWorkTimeID();
    // 		   $dbResult = $db->query('SELECT id FROM business_work_hours WHERE id=:id', [':id'=>$work_TimeID]);
    // 		} while($dbResult);
    		
    	
    // 		   $card_timeID = $db->query('SELECT id FROM business_time_cards WHERE id=:id', [':id'=>$i]);
    		   
    // 	       if($card_timeID){
    // 	           $start_hour = $generator->generateStartHour();
    //     		   $end_hour = $generator->generateEndHour();
    //     		   $su = 1;
    //     		   $mo = $generator->generateDayStatus();
    //     		   $tu = 1;
    //     		   $we = $generator->generateDayStatus();
    //     		   $th = 1;
    //     		   $fr = $generator->generateDayStatus();
    //     		   $sa = $generator->generateDayStatus();
        		   
    //     		   $created_at = $generator->generateCreatedAt();
    //     		   $updated_at = $generator->generateUpdatedAt();
        		   
    // 	           $dbResult = $db->query("INSERT INTO business_work_hours VALUES (:id, :time_card_id, :start_hour, :end_hour,:su,:mo,:tu,:we,:th,:fr,:sa, :created_at ,:updated_at)", [":id"=>$work_TimeID, ":time_card_id"=>$card_timeID[0]['id'] , ":start_hour"=>$start_hour, ":end_hour"=>$end_hour,":su"=>$su,":mo"=>$mo,":tu"=>$tu,":we"=>$we,":th"=>$th,":fr"=>$fr,":sa"=>$sa, ":created_at"=>$created_at, ":updated_at"=>$updated_at]);
    //                  echo $i . " -- "."\n";
    // 	       }
    //       }


//INSDERT TO buisness_settings ****************************************************************************
    //   for($i=248; $i<10250; $i++){
		  
		  
		  //$business_id = $db->query('SELECT id FROM business WHERE id=:id', [':id'=>$i]); 
		  //if($business_id){
		  // $waiting_queue = $generator->generateBsuinessWaitingQueue();
		  // $email_notifications = $generator->generateBsuinessEmailNotifications();
		  // $capacity = $generator->generateBsuinessCapacity();
		  // $work_capacity = $generator->generateBsuinessWorkCapacity();
		  // $service_time = $generator->generateBsuinessServiceTime();
		  // $created_at = $generator->generateCreatedAt();
		  // $updated_at = $generator->generateUpdatedAt();

	   // $dbResult = $db->query("INSERT INTO business_settings VALUES (:business_id, :waiting_queue, :email_notifications, :capacity, :work_capacity, :service_time, :created_at ,:updated_at)", [":business_id"=>$business_id[0]['id'], ":waiting_queue"=>$waiting_queue , ":email_notifications"=>$email_notifications, ":capacity"=>$capacity,":work_capacity"=>$work_capacity,":service_time"=>$service_time, ":created_at"=>$created_at, ":updated_at"=>$updated_at]);

    //      echo $i . " -- " ."\n";   
		  //}
		   
		
	   //}
	   
	//INSDERT TO ratings ****************************************************************************
    //  for($i=248; $i<10250; $i++){
		  
		  //do{
		  //$rating_id = $generator->generateRatingID();
		  //$dbResult = $db->query('SELECT id FROM ratings WHERE id=:id', [':id'=>$rating_id]);
		  //}while($dbResult);
		  
		  //$business_id = $db->query('SELECT id FROM business WHERE id=:id', [':id'=>$i]); 
		  //if($business_id){
		  
		  // $rating = $generator->generateRating();
		  // $created_at = $generator->generateCreatedAt();
		  // $updated_at = $generator->generateUpdatedAt();

	   // $dbResult = $db->query("INSERT INTO ratings VALUES (:id,:business_id,  :rating, :created_at ,:updated_at)", [":id"=>$rating_id,":business_id"=>$business_id[0]['id'], ":rating"=>$rating, ":created_at"=>$created_at, ":updated_at"=>$updated_at]);

    //      echo $i . " -- " ."\n";   
		  //}
		   
		
	   //}   
  //INSERT TO RESERVATIONS ****************************************************************************
  

//   for ($i =42; $i < 10043; $i++) {
      
//       $reservation_id = null;
//       $business_id= null;
//       $location_id= null;
//         do {
//           $reservation_id = $generator->generateReservationID();
//           $dbResult = $db->query('SELECT id FROM reservations WHERE id=:reservation_id', [':reservation_id'=>$reservation_id]);
//         } while($dbResult);
//         	$user_id = rand(1,20);
//     	    $location_id = $i;
//          	$business_id = $db->query('SELECT business_id FROM business_locations WHERE id=:location_id', [':location_id'=>$location_id]);	
//       if($business_id){
//             $status = rand(1,3);
        
//         $created_at = $generator->generateTimeBetween("2021-01-01 00:00","2022-01-29 23:59");
//         $updated_at = $generator->generateUpdatedAt();

//   $db->query("INSERT INTO reservations VALUES (:id, :business_id,:user_id, :location_id,  :status, :created_at,:updated_at )", [":id"=>$reservation_id, ":business_id"=>$business_id[0]['business_id'], ":user_id"=>$user_id, ":location_id"=>$location_id,  ":status"=>$status,":created_at"=>$created_at,":updated_at"=>$updated_at]);

//     echo $i . " -- "."\n";
//       }
       
//   }

  //INSDERT TO RESERVATIONS ****************************************************************************
  // $userID = null;
  // $email = null;

  // for ($i=0; $i < 100; $i++) {

  //   do {
  //     $userID = $generator->generateUserID();
  //     $dbResult = $db->query('SELECT user_id FROM users WHERE user_id=:user_id', [':user_id'=>$userID]);
  //   } while($dbResult);

  //   do {
  //     $email = $generator->generateEmails();
  //     $dbResult = $db->query('SELECT email FROM users WHERE email=:email', [':email'=>$email]);
  //   } while($dbResult);

    
  //   $pw = '$2y$10$LxvBZEIN9lQszerDk6FhTehm7YG8kiC5HtIGpl1ka9kx4RhYqls6K';
  //   $firstName = $generator->generateFirstName();
  //   $last_name = $generator->generateLastName();
  //   $phone = $generator->generatePhones();
  //   $profilePicture = "owners-data/e055940f0ec55e94fd10/profile-picture/e055940f0ec55e94fd10_1.jpg";
  //   $bd = $generator->generateTimeBetween("1994-01-01 00:00","1996-01-01 23:59");
  //   $gender = "Male";
  //   $timestamp = $generator->generateTimeBetween("2020-09-01 00:00","2020-09-07 23:59");;
  //   $status = rand(0,4);

  //   $db->query("INSERT INTO users VALUES (:user_id, :email, :pw, :first_name, :last_name, :phone, :profile_picture, :bd, :gender, :timestamp, :status)", [":user_id"=>$userID, ":email"=>$email, ":pw"=>$pw, ":first_name"=>$firstName, ":last_name"=>$last_name, ":phone"=>$phone, ":profile_picture"=>$profilePicture, ":bd"=>$bd, ":gender"=>$gender, ":timestamp"=>$timestamp, ":status"=>$status]);

  //   echo $i . " -- ";
  // }


  // INSDERT TO SUB CATEGRIES ****************************************************************************
  // $categoryID = null;
  // $subCategoryID = null;

  // for ($i=0; $i < 3000; $i++) {

  //   do {
  //     $subCategoryID = $generator->generateSubCategoryID();
  //     $dbResult = $db->query('SELECT sub_category_id FROM categories_sub WHERE sub_category_id=:sub_category_id', [':sub_category_id'=>$subCategoryID]);
  //   } while($dbResult);

  //   $categoryID = $generator->generateCategoryID();
  //   $name = $generator->generateFullName();
  //   $arabic = $generator->generateUserID();
  //   $french = $generator->generateLastName();
  //   $timestamp = $generator->generateTimeBetween("2020-01-01 00:00","2020-08-31 23:59");

  //   $db->query("INSERT INTO categories_sub VALUES (:sub_category_id, :category_id, :name, :arabic, :french, :image, :timestamp, :status)", [":sub_category_id"=>$subCategoryID, ":category_id"=>$categoryID, ":name"=>$name, ":arabic"=>$arabic, ":french"=>$french, ":image"=>"", ":timestamp"=>$timestamp, ":status"=>""]);

  //   echo $i . " -- ";
  // }


   // INSDERT TO CATEGRIES ****************************************************************************
  // $categoryID = null;

  // for ($i=0; $i < 3000; $i++) {

  //   do {
  //     $categoryID = $generator->generateCategoryID();
  //     $dbResult = $db->query('SELECT category_id FROM categories WHERE category_id=:category_id', [':category_id'=>$categoryID]);
  //   } while($dbResult);

  //   $name = $generator->generateFullNames();
  //   $arabic = $generator->generateFirstName();
  //   $french = $generator->generateLastName();
  //   $timestamp = $generator->generateTimeBetween("2020-01-01 00:00","2020-08-31 23:59");

  //   $db->query("INSERT INTO categories VALUES (:category_id, :name, :arabic, :french, :image, :timestamp, :status)", [":category_id"=>$categoryID, ":name"=>$name, ":arabic"=>$arabic, ":french"=>$french, ":image"=>"", ":timestamp"=>$timestamp, ":status"=>""]);

  //   echo $i . " -- ";
  // }


   $db->query("UPDATE owners SET password =:password WHERE owners.id =:id",["password"=> password_hash('12345', PASSWORD_DEFAULT),"id"=>'5347864983215283'] )
  
?>