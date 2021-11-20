<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function sendConfirmationEmail($ownerId, $email, $fullName, $token,$code, $lang){

  $domainLink = "http://api-d72lx729vhg.efodia.com/";
  
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

  try {

    //Server settings
    // $mail->Host       = 'sg3plcpnl0089.prod.sin3.secureserver.net';     // Set the SMTP server to send through
    // $mail->Username   = 'no-reply@efodia.com';                         // SMTP username
    // $mail->Password   = 'J{2J8l-V#rNBsm}';                           // SMTP password
    // $mail->isSMTP();                                                    // Send using SMTP
    // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                              // Enable verbose debug output
    // $mail->SMTPAuth   = true;                                           // Enable SMTP authentication
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    // $mail->Port       = 465;

    //Server settings
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->SMTPAuth = false;
    $mail->SMTPAutoTLS = false; 
    $mail->Port = 25;
   

    $mail->setFrom('no-reply@efodia.com', 'Efodia | No Reply');
    // $mail->addReplyTo('NoReply@efodia.com', 'Efodia | NoReply');

    $mail->addAddress($email, $fullName);     // Add a email
    

    $message = "

    <style>
      .activate{
        width: max-content;
        background: #253570;
        color: #fff;
        padding: 5px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 25px 0px 40px 0px;
      }

      .note{
        font-size: 13px;
      }
     
    //   .headline{
    //      color: black;
    //      text-align: center;
    //   }
    //   .cod-pa{
    //      font-size: 26px;
    //      color: darkblue;
    //      letter-spacing: 10px;
    //      text-align: center;
    //      font-weight: bolder;
    //      border: 1px solid black;
    //      width: 18%;
    //      margin-left: 464px;
    //   }
    </style>

    Hi <b>". $fullName ."</b>, Welcome to Efodia, <br>
    Click on <b>activate</b> to activate your account:
    <a class='activate' href='". $domainLink ."signup/confirm/index.php?id=". $ownerId ."&token=". $token ."&lang=". $lang ."'>Activate</a>
    If you are unable to open the link above, please copy the URL below to the address bar of your browser: <br><br>
    <a href='". $domainLink ."signup/confirm/index.php?id=". $ownerId ."&token=". $token ."&lang=". $lang ."'>". $domainLink ."signup/confirm/index.php?id=". $ownerId ."&token=". $token ."&lang=". $lang ."</a> <br><br>
    <br>
    
    <h2 class='headline'>Activation Code : $code</h2>
    
   
    *****************************************************************<br>
    <code class='note'>This email and its attachments contain confidential information from <b>On Time Group</b>, which is intended only for the person or entity whose address is listed above. Any use of the information contained herein in any way (including, but not limited to, total or partial disclosure, reproduction, or dissemination) by persons other than the intended recipients is prohibited. If this email is not for you, please notify the sender by phone or email immediately and delete it!</code><br>
    *****************************************************************";
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Efodia | Please activate your account';
    $mail->Body    = $message;

    $mail->send();
    
  } catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    // echo $e;
  }
}

function sendResetPasswordCodeEmail($ownerId, $email, $fullName, $token, $code, $lang){

  $domainLink = "http://api-d72lx729vhg.efodia.com/";
  
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

  try {

    //Server settings
    // $mail->Host       = 'sg3plcpnl0089.prod.sin3.secureserver.net';     // Set the SMTP server to send through
    // $mail->Username   = 'no-reply@efodia.com';                         // SMTP username
    // $mail->Password   = 'J{2J8l-V#rNBsm}';                           // SMTP password
    // $mail->isSMTP();                                                    // Send using SMTP
    // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                              // Enable verbose debug output
    // $mail->SMTPAuth   = true;                                           // Enable SMTP authentication
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    // $mail->Port       = 465;

    //Server settings
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->SMTPAuth = false;
    $mail->SMTPAutoTLS = false; 
    $mail->Port = 25;
   

    $mail->setFrom('no-reply@efodia.com', 'Efodia | No Reply');
    // $mail->addReplyTo('NoReply@efodia.com', 'Efodia | NoReply');

    $mail->addAddress($email, $fullName);     // Add a email
    

    $message = "

    <style>
      .activate{
        width: max-content;
        background: #253570;
        color: #fff;
        padding: 5px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 25px 0px 40px 0px;
      }

      .note{
        font-size: 13px;
      }
     
    //   .headline{
    //      color: black;
    //      text-align: center;
    //   }
    //   .cod-pa{
    //      font-size: 26px;
    //      color: darkblue;
    //      letter-spacing: 10px;
    //      text-align: center;
    //      font-weight: bolder;
    //      border: 1px solid black;
    //      width: 18%;
    //      margin-left: 464px;
    //   }
    </style>

    Hi <b>". $fullName ."</b>, Welcome to Efodia, <br>
    This Code  <b>Change</b> your password:
     <br><br>
    <br>
    
    <h2 class='headline'>Reset Code : $code</h2>
    
   
    *****************************************************************<br>
    <code class='note'>This email and its attachments contain confidential information from <b>On Time Group</b>, which is intended only for the person or entity whose address is listed above. Any use of the information contained herein in any way (including, but not limited to, total or partial disclosure, reproduction, or dissemination) by persons other than the intended recipients is prohibited. If this email is not for you, please notify the sender by phone or email immediately and delete it!</code><br>
    *****************************************************************";
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Efodia | Change Account Password';
    $mail->Body    = $message;

    $mail->send();
    
  } catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    // echo $e;
  }
}