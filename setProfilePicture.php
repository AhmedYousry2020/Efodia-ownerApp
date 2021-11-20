<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
    
    $token = getBearerToken();
    $validator->validateToken($token);
    
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    
    if ($validator->error_validation == 0) {

     if(isset($_FILES['profile_picture'])){

      $profilePicturePath = "owners-data/{$ownerID}/profile-picture/";
      $profilePictureExtension = pathinfo($_FILES['profile_picture']['name'])['extension'];
      $profilePictureName = "owners-data/{$ownerID}/profile-picture/{$ownerID}_1.{$profilePictureExtension}";

      if(!file_exists($profilePicturePath)){

        if (file_exists($profilePictureName)) 
          unlink($profilePictureName);

        mkdir($profilePicturePath, 0777, true);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePictureName);
        
      }else{
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePictureName);
      }

      $dbResult = $db->query("UPDATE owners SET profile_picture=:profile_picture WHERE id=:owner_id", [":profile_picture"=>"$profilePictureName", ":owner_id"=>$ownerID]);

      if ($dbResult){
        
        successResponse("Added Profile Photo Successfully");
        $ownerStatus = $db->query("SELECT status FROM owners WHERE id=:owner_id", [":owner_id"=>$ownerID])[0]['status'];
      
        if ($ownerStatus != OWNER_ACTIVE) {
          $db->query("UPDATE owners SET status=:status WHERE id=:owner_id", [":status"=>OWNER_PROFILE_PICTURE, ":owner_id"=>$ownerID]);
        }

      }else{
        failResponse();
       
      }//Setting profile picture
      
     }else{
        errDocumentsRequired("You must choose profile picture for yourself");
     }//Profile Picture Set

    } //check validation

  }else{
    errServerAuth();
  }//Server Auth

?>