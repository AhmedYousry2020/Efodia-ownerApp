<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
   
   
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];

    
      $category = !isset($_GET["category"]) ? 'all' : $_GET["category"];
      
      if ($category == "all") {

        $categories = $db->query("SELECT * FROM categories WHERE status=:status", [":status"=>STATUS_ACTIVE]);
        ($categories) ? printResult(json_encode($categories)) : errNoData();
        
      }else{
        
        $categories = $db->query("SELECT * FROM categories_sub WHERE category_id=:category_id AND status=:status", [":category_id"=>$category, ":status"=>STATUS_ACTIVE]);
        ($categories) ? printResult(json_encode($categories)) : errNoData();
        
      }
     
  }else{
    errServerAuth();
  }//Server Auth

?>