<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
    
    $token = getBearerToken();
    $validator->validateToken($token);
    
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $businessID = $db->query("SELECT id FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID])[0]['id'];

    if ($validator->error_validation == 0) {

        if(isset($_FILES['business-picture'])){

        $businessPicturePath = "business-data/{$businessID}/business-picture/";
        $businessPictureExtension = pathinfo($_FILES['business-picture']['name'])['extension'];
        $businessPictureName = "business-data/{$businessID}/business-picture/{$businessID}_1.{$businessPictureExtension}";

        if(!file_exists($businessPicturePath)){

            if (file_exists($businessPictureName)) 
            unlink($businessPictureName);

            mkdir($businessPicturePath, 0777, true);
            move_uploaded_file($_FILES['business-picture']['tmp_name'], $businessPictureName);
            
        }else{
            move_uploaded_file($_FILES['business-picture']['tmp_name'], $businessPictureName);
        }
        $businessPictureName = DOMAIN_LINK .$businessPictureName;    
        $dbResult = $db->query("UPDATE business SET image=:image WHERE id=:business_id", [":image"=>$businessPictureName, ":business_id"=>$businessID]);

        if ($dbResult){
            
          successResponse("Added Business Photo Successfully");
          $businessStatus = $db->query("SELECT status FROM business WHERE id=:business_id", [":business_id"=>$businessID])[0]['status'];
        
            if ($businessStatus != BUSINESS_ACTIVE) {
                $db->query("UPDATE business SET status=:status WHERE id=:business_id", [":status"=>BUSINESS_PROFILE_PICTURE, ":business_id"=>$businessID]);
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