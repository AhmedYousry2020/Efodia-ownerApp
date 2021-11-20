<?php
  require_once("_config.php");
  header('Content-Type: application/json');

  (!isset($_SERVER['HTTP_PHP_AUTH_USER']) || !isset($_SERVER['HTTP_PHP_AUTH_PW'])) ? exit(json_encode('Server authentications are required')) : '' ;
  if($_SERVER['HTTP_PHP_AUTH_USER'] == AUTH_USER && $_SERVER['HTTP_PHP_AUTH_PW'] == AUTH_PW){
    $lang = !isset($_GET['lang']) ? 'en' : $_GET['lang'];

    $subCategory = !isset($_GET["sub_category"]) ? 'all' : $_GET["sub_category"];
    

    if ($subCategory == "all") {

      $dbResult = $db->query("SELECT * FROM categories_sub WHERE status=:status", [":status"=>STATUS_ACTIVE]);
      ($dbResult) ? printResult(json_encode($dbResult)) : errNoData(); ;

    }else{

      $dbResult = $db->query("SELECT * FROM categories_sub WHERE id=:sub_category_id AND status=:status", [":sub_category_id"=>$subCategory, ":status"=>STATUS_ACTIVE]);
      ($dbResult) ? printResult(json_encode($dbResult)) : errNoData(); ;

    }

  }else{
    errServerAuth();
  }//Server Auth

?>