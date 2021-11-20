<?php

  // error_reporting(0); 
  set_time_limit(0);

  require_once("_databaseConnection.php");
  require_once("_generators.php");
  require_once("_timestamp.php");
  require_once("_errorCodes.php");
  require_once("_successCodes.php");
  require_once("_validation.php");
  require_once("email-confirm/index.php");

  //$db = new DB("127.0.0.1", "efodia2", "root", "");
  $db = new DB("localhost", "efodia", "efodia", "Hqfqbv6kbf@123");
  $generator = new Generators();
  $time = new Dates();
  $validator = new Validation();
  

  // define("DOMAIN_LINK", 'http://127.0.0.1:8080/');
  define("DOMAIN_LINK", 'http://api-d72lx729vhg.efodia.com/');

  //RESERVATIONS STATUS *******************************************************
  define("R_CANCEL", '0');
  define("R_CONFIRM", '1');
  define("R_WAITING", '2');
  define("R_HISTORY", '3');

  //API AUTHENTICATION  *******************************************************
  define("AUTH_USER", 'sam');
  define("AUTH_PW", '1234');

  //STATUS TYPES  *******************************************************
  define("STATUS_DISABLED", 0);
  define("STATUS_ACTIVE", 1);

  //OWNER STATUS   *******************************************************
  define("OWNER_DISABLED", 0);
  define("OWNER_ACTIVE", 1);
  define("OWNER_INIT", 2);
  define("OWNER_PROFILE_PICTURE", 3);
  define("OWNER_LOCATIONS", 4);
  
  //BUSINESS STATUS  *******************************************************
  define("BUSINESS_DISABLED", 0);
  define("BUSINESS_ACTIVE", 1);

  define("BUSINESS_INIT", 2);
  
  define("BUSINESS_PROFILE_PICTURE", 3);
  define("BUSINESS_LOCATIONS", 4);
  define("BUSINESS_HOURS", 5);
  define("BUSINESS_SETTINGS", 6);


  //Functions  *******************************************************
  function printResult($data){
    echo $data;
    http_response_code(200);
  }

  function addOwner($cols, $values){
    
    global $db;
    $finalCols = '';
    $finalValues = '';
    $finalData = [];

    for ($i=0; $i < count($cols); $i++) { 
      $finalCols .= $cols[$i] . ', ';
      $finalValues .= ':' . $cols[$i] . ', ';
      $finalData = $finalData + [":$cols[$i]" => $values[$i]];
    }
    
    $finalCols = rtrim($finalCols, ", ");
    $finalValues = rtrim($finalValues, ", ");
    
    $data = $db->query("INSERT INTO owners ($finalCols) VALUES ($finalValues)", $finalData);

    return $data;

  }
  
  function addBusiness($cols, $values){
    
    global $db;
    $finalCols = '';
    $finalValues = '';
    $finalData = [];

    for ($i=0; $i < count($cols); $i++) { 
      $finalCols .= $cols[$i] . ', ';
      $finalValues .= ':' . $cols[$i] . ', ';
      $finalData = $finalData + [":$cols[$i]" => $values[$i]];
    }
    
    $finalCols = rtrim($finalCols, ", ");
    $finalValues = rtrim($finalValues, ", ");
    
    $data = $db->query("INSERT INTO business ($finalCols) VALUES ($finalValues)", $finalData);

    return $data;

  }
  function addLocation($cols, $values, $table){
    
    global $db;
    $finalCols = '';
    $finalValues = '';
    $finalData = [];

    for ($i=0; $i < count($cols); $i++) { 
      $finalCols .= $cols[$i] . ', ';
      $finalValues .= ':' . $cols[$i] . ', ';
      $finalData = $finalData + [":$cols[$i]" => $values[$i]];
    }
    
    $finalCols = rtrim($finalCols, ", ");
    $finalValues = rtrim($finalValues, ", ");
    
    $data = $db->query("INSERT INTO $table ($finalCols) VALUES ($finalValues)", $finalData);

    return $data;

  }
  

  function addOwnerPhone($ownerId, $phone){

    global $db;

    $data = $db->query("INSERT INTO owners_phones (owner_id, phone_number) VALUES (:owner_id, :phone_number)", [":owner_id"=>$ownerId, ":phone_number"=>$phone]);

    return $data;
  }

  function addBusinessPhone($businessId, $phone){

    global $db;

    $data = $db->query("INSERT INTO business_phones (business_id, phone_number) VALUES (:business_id, :phone_number)", [":business_id"=>$businessId, ":phone_number"=>$phone]);

    return $data;
  }
  function addBusinessEmail($businessId, $email){

    global $db;

    $data = $db->query("INSERT INTO business_emails (business_id, email) VALUES (:business_id, :email)", [":business_id"=>$businessId, ":email"=>$email]);

    return $data;
  }

  function setOwnerToken($ownerId){
    
    global $db;
    global $generator;
    global $time;

    do {
      $token = $generator->generateToken();
      $dbResult = $db->query('SELECT token FROM owners_tokens WHERE token=:token', [':token'=>$token]);
    } while($dbResult);

    $db->query("INSERT INTO owners_tokens (token,owner_id,start_date,end_date,status,created_at) VALUES (:token, :owner_id, :start_date, :end_date,:status,:created_at)", [":token"=>$token, ":owner_id"=>$ownerId, ":start_date"=>$time->getNow(), ":end_date"=>$time->getNowPlusDays(60),":status"=>STATUS_ACTIVE,":created_at"=>$time->getNow()]);
    
    return $token;

  }

  function sendOwnerConfirmEmail($ownerId, $email, $firstName, $lastName){

    global $db;
    global $generator;
    $lang = "en";

    $token = $generator->generateConfirmationToken();
    $db->query('REPLACE INTO owners_confirm (id,email,code) VALUES (:owner_id,:email, :code)', [":owner_id"=>$ownerId,":email"=>$email, ":code"=>$token]);
    $code = $db->query('SELECT code FROM owners_confirm WHERE id=:owner_id',[":owner_id"=>$ownerId])[0]['code'];
    sendConfirmationEmail($ownerId, $email, "$firstName $lastName", $token,$code, $lang);

  }
  
  function sendOwnerResetPasswordCode($ownerId, $email, $firstName, $lastName){

    global $db;
    global $generator;
    $lang = "en";

    $token = $generator->generateConfirmationToken();
    $db->query('REPLACE INTO owners_password_resets (id,email,code) VALUES (:owner_id,:email, :code)', [":owner_id"=>$ownerId,":email"=>$email, ":code"=>$token]);
    $code = $db->query('SELECT code FROM owners_password_resets WHERE id=:owner_id',[":owner_id"=>$ownerId])[0]['code'];
    sendResetPasswordCodeEmail($ownerId, $email, "$firstName $lastName", $token,$code, $lang);
    

  }

    
  function createOwnerFolder($ownerId){

    $profilePictures = "./owners-data/$ownerId/profile-picture";
    $documents = "./owners-data/$ownerId/documents";

    mkdir($profilePictures, 0777, true);
    mkdir($documents, 0777, true);
    
  }

  function getOwnerBasicInfo($token){

    global $db;
    global $DOMAIN_LINK;

    $data = $db->query('SELECT owners_tokens.token, owners.first_name, owners.last_name, owners.email,owners.gender,phone_number, owners.status FROM owners_tokens LEFT JOIN owners ON owners_tokens.token = :token LEFT JOIN owners_phones on owners.id = owners_phones.owner_id WHERE owners.id = owners_tokens.owner_id', [":token"=>$token]);

    // if ($data[0]['profile_picture'] != ''){
    //   $data[0]['profile_picture'] = DOMAIN_LINK . $data[0]['profile_picture'];
    // }
    
    return $data;
  }
  function getBusinessBasicInfo($business_id){

    global $db;
    global $DOMAIN_LINK;

    $data = $db->query('SELECT business.id as business_id,business.name_en,phone_number,email, business.status FROM business LEFT JOIN business_phones ON business.id = business_phones.business_id LEFT JOIN business_emails ON business.id = business_emails.business_id WHERE business.id =:business_id', [":business_id"=>$business_id]);

    // if ($data[0]['profile_picture'] != ''){
    //   $data[0]['profile_picture'] = DOMAIN_LINK . $data[0]['profile_picture'];
    // }
    
    return $data;
  }

  function checkOwnerLogin($email, $pw){

    global $db;

    if ($db->query('SELECT email FROM owners WHERE email=:email', [':email'=>$email])) {

      $hashedPass = $db->query('SELECT pw FROM owners WHERE email=:email', [':email'=>$email])[0]['pw'];

      if (password_verify($pw, $hashedPass)) {

        $ownerId = $db->query('SELECT owner_id FROM owners WHERE email=:email', [':email'=>$email])[0]['owner_id'];
   
        $token = setOwnerToken($ownerId);

        return getOwnerBasicInfo($token);

      } else {
        return errTokenUnvalid("Sorry, your password was incorrect. Please double-check your password.");
      }//Password Auth

    } 
    else {
      return errTokenUnvalid("The email you entered doesn't belong to an account. Please check your email and try again.");
    }//Email Auth

  }

  function getOwnerStatus($ownerId){

    global $db;

    $data = $db->query("SELECT status from owners WHERE owner_id=:owner_id", [":owner_id"=>$ownerId]);

    return $data;

  }

  function changeOwnerStatus($ownerId, $status){

    global $db;

    $data = $db->query("UPDATE owners SET status=:status WHERE owner_id=:owner_id", [":status"=>$status, ":owner_id"=>$ownerId]);

    return $data;

  }

  function getAuthorizationHeader(){
    $requestHeaders = apache_request_headers();
    $Auth=null;
    if(isset($requestHeaders["Authorization"])){
        $Auth = $requestHeaders["Authorization"];
    }
    return $Auth;
  }
  function getBearerToken(){
    $token = null;
    $bearerToken = getAuthorizationHeader();
    if(!empty($bearerToken)){
      $bearerToken = explode(' ',$bearerToken);
      $token = $bearerToken[1];
      return $token;
    }

    return $token;
  }
  function execptItem($array,$item){
     unset($array[$item]);
     return $array;
  }
  

?>