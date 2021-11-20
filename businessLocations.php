<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $token = getBearerToken();
    $validator->validateToken($token);

    $validateData = execptItem($_POST,'landmark'); 
    $validator->ValidateRequired($_POST);

    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
    $locationStatus = !isset($_GET['location_status']) ? 'get' : $_GET['location_status'];

    $addressLine = null;
    $ownerID = $db->query("SELECT owner_id FROM owners_tokens WHERE token=:token", [":token"=>$token])[0]['owner_id'];
    $businessID = $db->query("SELECT id FROM business WHERE owner_id=:owner_id", [":owner_id"=>$ownerID])[0]['id'];

    if ($locationStatus == 'add' || $locationStatus == 'update') {
      
      $locationName = $validator->validateText('location_name', $_POST['location_name']);
      $countryName = $validator->validateText('country_name', $_POST['country_name']);
      $stateName = $validator->validateText('state_name', $_POST['state_name']);
      $cityName = $validator->validateText('city_name', $_POST['city_name']);
      $areaName = $validator->validateText('area_name', $_POST['area_name']);
      $building = $validator->validateInteger('building', $_POST['building']);
      $floor = $validator->validateInteger('floor', $_POST['floor']);
      $unit = $validator->validateInteger('unit', $_POST['unit']);
      $landmark = isset($_POST['landmark']) ? $validator->validateText('landmark', $_POST['landmark']) : '';
      $latitude = $validator->validateText('latitude', $_POST['latitude']);
      $longitude = $validator->validateText('longitude', $_POST['longitude']);

      $addressLine = "$countryName, $stateName, $cityName, $areaName, $building";
    }

    if ($validator->error_validation == 0) {

     if ($locationStatus == "add") { 
      
      $cols = ['business_id','location_name','country_name', 'state_name', 'city_name', 'area_name', 'building','landmark','floor','unit','latitude','longitude','address_line','status'];
      $values = [$businessID,$locationName,$countryName, $stateName, $cityName, $areaName,$landmark, $building, $floor,$unit,$latitude,$longitude,$addressLine,STATUS_ACTIVE];
      $locationId =  addLocation($cols,$values,'business_locations');
      if ($locationId) {
        successResponse("Location Added Successfully");  
        $businessStatus = $db->query("SELECT status FROM business WHERE id=:business_id", [":business_id"=>$businessID])[0]['status'];

        if ($businessStatus != BUSINESS_ACTIVE) {
          $db->query("UPDATE business SET status=:status WHERE id=:business_id", [":status"=>BUSINESS_LOCATIONS, ":business_id"=>$businessID]);
        }
        
      }else{
        failResponse();
      }
  
     }elseif($locationStatus == "update"){

      $locationId = !isset($_GET['location_id']) ? '' : $_GET['location_id'];
   
      $locationID = $db->query("SELECT id FROM business_locations WHERE id=:location_id AND business_id = :business_id AND status=:status", [":location_id"=>$locationId, ":business_id"=>$businessID,":status"=>STATUS_ACTIVE]);
      
      if($locationID){
       $locationID = $locationID[0]['id'];
        $dbResult = $db->query("UPDATE business_locations SET business_id=:business_id ,location_name=:location_name, country_name=:country_name, state_name=:state_name, city_name=:city_name, area_name=:area_name, building=:building, floor=:floor, unit=:unit, address_line=:address_line, latitude=:latitude, longitude=:longitude WHERE id=:location_id", ["business_id"=>$businessID,":location_name"=>$locationName, ":country_name"=>$countryName, ":state_name"=>$stateName, ":city_name"=>$cityName, ":area_name"=>$areaName, ":building"=>$building, ":floor"=>$floor, ":unit"=>$unit,":address_line"=>$addressLine, ":latitude"=>$latitude, ":longitude"=>$longitude, ":location_id"=>$locationID]);
        $dbResult ? successResponse("Updated Successfully") : failResponse();

      }else {
        errParmsUnvalid();
      }

     }elseif($locationStatus == "delete"){

      $locationId = $_GET['location_id'];
      $locationID = $db->query("SELECT id FROM business_locations WHERE id=:location_id AND status=:status", [":location_id"=>$locationId, ":status"=>STATUS_ACTIVE]);
      if($locationID){
        $locationID = $locationID[0]['id'];
        $dbResult = $db->query("UPDATE business_locations SET status=:status WHERE id=:location_id",[":status"=>STATUS_DISABLED, ":location_id"=>$locationID]);
        $dbResult ? successResponse("deleted Successfully") : failResponse();

      }else {
        errParmsUnvalid();
      }

     }elseif($locationStatus == "get"){

      $dbResult = $db->query("SELECT id as location_id, business_id, location_name, country_name, state_name, city_name, area_name, building, floor, unit, landmark, address_line, latitude, longitude FROM business_locations WHERE business_id=:business_id AND status=:status", [":business_id"=>$businessID, ":status"=>STATUS_ACTIVE]);

      ($dbResult) ? printResult(json_encode($dbResult)) : errNoData();

     }

    } // check validation

  }else{
    errServerAuth();
  }//Server Auth

?>