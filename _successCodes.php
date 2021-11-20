<?php 


define("SUCCESS_CREATED", 201);

function successResponse($message = "Added Successfully"){
    echo json_encode("{'success': {'message': '". $message ."', 'code',". SUCCESS_CREATED ."}}");
    http_response_code(201);
  }


?>