<?php
  require_once("_config.php");
  header('Content-Type: application/json');
  
  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are not correct')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER  &&  $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $ownerID = null;
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
  
    $validator->ValidateRequired($_POST);
    
    $firstName = $validator->validateText('first_name',$_POST['first_name']);
    $lastName = $validator->validateText('last_name',$_POST['last_name']);
    $email = $validator->validateEmail('email',$_POST['email']);
    $phone = $validator->validatePhone('phone',$_POST['phone']);
    $password = $validator->test_on_data($_POST['password']);
    $birth_date = $validator->validateDate('birth_date',$_POST['birth_date']);
    $gender = $validator->test_on_data($_POST['gender']);
    
    if($validator->error_validation == 0){

        //check if email exists query
        $emailCheck = $db->query("SELECT email from owners Where email=:email", [":email"=>$email]);
        if (!$emailCheck) {
            
          //check if phone exists
          $phoneCheck = $db->query("SELECT phone_number FROM owners_phones WHERE phone_number=:phone_number", [":phone_number"=>$phone]);
          
          if (!$phoneCheck) {
            $cols = ['email', 'password', 'first_name', 'last_name', 'birth_date', 'gender', 'status','created_at','updated_at'];
            $values = [$email, password_hash($password, PASSWORD_DEFAULT), $firstName, $lastName, $birth_date, $gender, OWNER_INIT, $time->getNow(),$time->getNow()];
            
            $ownerId = addOwner($cols, $values);

            $token = setOwnerToken($ownerId);
            
            addOwnerPhone($ownerId, $phone);
            
            createOwnerFolder($ownerId);
            
            printResult( json_encode( getOwnerBasicInfo($token) ) );

            sendOwnerConfirmEmail($ownerId, $email, $firstName, $lastName);

          }else{
            echo errDuplication("Phone already exists");
          }//end phone check

        }else{
          echo errDuplication("Email already exists");
        }//Email Check
        
    } // validation  check 
  }else{
    errServerAuth();
  }//Server Auth

?>