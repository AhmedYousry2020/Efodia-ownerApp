<?php

  require_once("_config.php");

  if($_SERVER['PHP_AUTH_USER'] == AUTH_USER && $_SERVER['PHP_AUTH_PW'] == AUTH_PW){


    $info = pathinfo($_FILES['profile_picture']['name'])['extension'];

    echo "this is my extension {$info}";

  
  }
  

?>