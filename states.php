<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;

  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){

    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];
    $country_id = $_GET['country_id'];
    
    $states = $db->query("SELECT id, name_". $lang ." FROM locations_states WHERE country_id = :country_id", [":country_id"=>$country_id]);
    ($states) ? printResult(json_encode($states)) : errNoData();

  }else{
    errServerAuth();
  }//Server Auth

?>