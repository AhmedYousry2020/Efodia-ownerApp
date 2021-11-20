<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  if($_SERVER['PHP_AUTH_USER'] == AUTH_USER && $_SERVER['PHP_AUTH_PW'] == AUTH_PW){

    $data = json_decode(file_get_contents("php://input"));
    $lang = $data->lang;
    $state_id = $data->state_id;
    
    $cities = $db->query("SELECT city_id, name_". $lang ." FROM locations_cities WHERE state_id = :state_id", [":country_id"=>$country_id]);
    ($cities) ? printResult(json_encode($countries)) : errNoData();

  }else{
    errServerAuth();
  }//Server Auth

?>