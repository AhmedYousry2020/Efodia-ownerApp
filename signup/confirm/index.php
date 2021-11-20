<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Efodia | Activate Account</title>

  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

</head>
<body>

  <?php

    $id = $_GET['id'];
    $token = $_GET['token'];

    require_once("_config.php");

    $dbResult = $db->query("SELECT token from owners_tokens WHERE owner_id=:owner_id",[":owner_id"=>$id]);

    if($dbResult){
      $db->query("UPDATE owners SET status=:status WHERE owner_id=:owner_id",[":status"=>OWNER_PROFILE_PICTURE,":owner_id"=>$id]);
      
      require_once("success.html");
    }else{
      require_once("error.html");
    }
  ?>

</body>
</html>