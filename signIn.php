<?php
  
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
 
    $ownerID = null;
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
  
    $email = $_POST['email'];
    $password = $_POST['password'];
   
    $validator->ValidateRequired($_POST);
    $email = $validator->validateEmail('email',$_POST['email']);
    $password = $validator->test_on_data($_POST['password']);
    
    if($validator->error_validation == 0){
        if ($db->query('SELECT email FROM owners WHERE email=:email', [':email'=>$email])) {

          $hashedPass = $db->query('SELECT password FROM owners WHERE email=:email', [':email'=>$email])[0]['password'];
         
          if(password_verify($password, $hashedPass)) {

            $ownerID = $db->query('SELECT id FROM owners WHERE email=:email', [':email'=>$email])[0]['id'];
     
            $token = setOwnerToken($ownerID);
            $ownerData = $db->query('SELECT owners_tokens.token, owners.id, owners.email, owners.first_name, owners.last_name,phone_number, owners.profile_picture, owners.status FROM owners_tokens LEFT JOIN owners ON owners_tokens.token = :token LEFT JOIN owners_phones on owners.id = owners_phones.owner_id WHERE owners.id = :owner_id', [":token"=>$token, ":owner_id"=>$ownerID]);

            $ownerData[0]['profile_picture'] = DOMAIN_LINK  . $ownerData[0]['profile_picture'];

            printResult(json_encode($ownerData));

          } else {
            errTokenUnvalid("Sorry, your password was incorrect. Please double-check your password.");
          }//Password Auth

        } 
        else {
          errTokenUnvalid("The email you entered doesn't belong to an account. Please check your email and try again.");
        }//Email Auth

      }  //validation check   
  }else{
    errServerAuth();
  }//Server Auth

?>