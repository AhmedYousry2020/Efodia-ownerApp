<?php

  define("ERR_SERVER_AUTH", 511);
  define("ERR_TOKEN_UNVALID", 601);
  define("ERR_TOKEN_EXPIRED", 602);
  define("ERR_DUPLICATION", 603);
  define("ERR_PARMS_UNVALID", 604);
  define("ERR_DOCUMENTS_RQUIRED", 605);
  define("ERR_DATA_RQUIRED",606);
  
  define("FAIL_Request", 607);

  function errServerAuth($message = "Server authentications are not correct"){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". ERR_SERVER_AUTH ."}}");
    http_response_code(511);
  }

  function errTokenUnvalid($message = "Owner token is not valid"){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". ERR_TOKEN_UNVALID ."}}");
    http_response_code(401);
  }

  function errTokenExpired($message = "Owner token is expired"){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". ERR_TOKEN_EXPIRED ."}}");
    http_response_code(401);
  }

  function errDuplication($message = "Duplication found"){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". ERR_DUPLICATION ."}}");
    http_response_code(409);
  }

  function errParmsUnvalid($message = "Something went wrong, check body parameters", $code = 604){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". $code ."}}");
    http_response_code(400);
  }

  function errDocumentsRequired($message = "Documents required"){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". ERR_DOCUMENTS_RQUIRED ."}}");
    http_response_code(403);
  }

  function errDataRequired($message = "Data required"){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". ERR_DATA_RQUIRED ."}}");
    http_response_code(403);
  }
  function errNoData(){
    echo json_encode([]);
    http_response_code(200);
  }
  function failResponse($message = "Added Failed"){
    echo json_encode("{'error': {'message': '". $message ."', 'code',". FAIL_Request ."}}");
    http_response_code(606);
  }

?>