<?php

  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
    
    $token = getBearerToken();
    $validator->validateToken($token);
    
   
    $validator->ValidateRequired($_POST);
    
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
    $businessStatus = !isset($_GET['business_status']) ? 'get' : $_GET['business_status'];
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    
    
    if($businessStatus == 'add' || $businessStatus == 'update'){
        
        $business_name_en = $validator->validateText('business_en',$_POST['business_en']);
        $business_name_ar = $validator->validateText('business_ar',$_POST['business_ar']);
        $phone = $validator->validatePhone('phone',$_POST['phone']);
        $email = $validator->validateEmail('email',$_POST['email']);
        $categoryID = $validator->validateInteger('category_id',$_POST['category_id']);
        $subCategoryID = $validator->validateInteger('sub_category_id',$_POST['sub_category_id']);
        
    }
 
    if($validator->error_validation == 0){
        
         if($businessStatus == 'add'){
            
            //check if email exists query
            $emailCheck = $db->query("SELECT email from business_emails Where email=:email", [":email"=>$email]);
            if (!$emailCheck) {
            
            //check if phone exists
                $phoneCheck = $db->query("SELECT phone_number FROM business_phones WHERE phone_number=:phone_number", [":phone_number"=>$phone]);
                if(!$phoneCheck){  
                $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];  
                $cols = ['owner_id','name_en', 'name_ar', 'category_id', 'sub_category_id', 'created_at','updated_at','status'];
                $values = [$ownerID,$business_name_en, $business_name_ar, $categoryID, $subCategoryID, $time->getNow() , $time->getNow(), BUSINESS_INIT];
                    
                  $businessId = addBusiness($cols, $values);
                  addBusinessEmail($businessId, $email);
                  
                  addBusinessPhone($businessId, $phone);
                  
         
                  $businessId ?  printResult(json_encode(getBusinessBasicInfo($businessId)))  : failResponse() ; 
                }else{
                  echo errDuplication("Phone already exists");
                }//end phone check
            }else{
           echo errDuplication("Email already exists");
          }//Email Check

         }elseif($businessStatus == 'update'){
             $businessId = !isset($_GET['business_id']) ? '' : $_GET['business_id'];
             
              //check if email exists query
            $emailCheck = $db->query("SELECT email from business_emails Where email=:email AND business_id !=:business_id ", [":email"=>$email,":business_id"=>$businessId]);
            if (!$emailCheck) {
             //check if phone exists
            $phoneCheck = $db->query("SELECT phone_number FROM business_phones WHERE phone_number=:phone_number AND business_id !=:business_id", [":phone_number"=>$phone,":business_id"=>$businessId]);
            if(!$phoneCheck){  
            $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];  
            
            $db->query("UPDATE business_phones set phone_number=:phone_number WHERE business_id=:business_id",[':phone_number'=>$phone,':business_id'=>$businessId]);
             $db->query("UPDATE business_emails set email=:email WHERE business_id=:business_id",[':email'=>$email,':business_id'=>$businessId]);
            
            $dbResult = $db->query("UPDATE business set name_en=:name_en,name_ar=:name_ar WHERE id=:business_id",[':name_en'=>$business_name_en,':name_ar'=>$business_name_ar,':business_id'=>$businessId]);       

             $dbResult ? successResponse("Updated Successfully") : failResponse();
             
            }else{
                echo errDuplication("Phone already exists");
            }//end phone check
            }else{
           echo errDuplication("Email already exists");
          }//Email Check
         }elseif($businessStatus == 'get'){
             
            $dbResult = $db->query("SELECT id as business_id,name_en,image,category_id,sub_category_id,status FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID]);
            // if($dbResult){
            //     $dbResult[0]['image'] = DOMAIN_LINK . $dbResult[0]['image'];
            // }
        
          ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();
         }
        
    }// check validation

  }else{
    errServerAuth();
  }//Server Auth
?>
