<?php

  // error_reporting(0); 
  set_time_limit(0);

  require_once("_databaseConnection.php");


  // $db = new DB("127.0.0.1", "efodia", "root", "");
  $db = new DB("localhost", "efodia", "efodiaAdmin2463", "Sami@123");

  // define("DOMAIN_LINK", 'http://127.0.0.1/');
  define("DOMAIN_LINK", 'http://efodia-owner-api-2020091500001.otgcom.com/');


  //OWNER STATUS  *******************************************************
  define("OWNER_DISABLED", 0);
  define("OWNER_ACTIVE", 1);

  define("OWNER_INIT", 2);

  define("OWNER_PROFILE_PICTURE", 3);
  define("OWNER_LOCATIONS", 4);
  define("OWNER_HOURS", 5);
  define("OWNER_SETTINGS", 6);

?>