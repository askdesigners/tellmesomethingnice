<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

if (is_ajax()) {
    decode();
}

//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function decode(){

  $data = json_decode(file_get_contents('php://input'), true);

  sendMails($data);

}

function sendMails($maildata){

  $me = 'ryan@tellmesomethingnice.com';
  $them = $maildata["email"];
  
  $subjectMe = 'New enquiry';
  $subjectThem = 'Thanks for the enquiry!';
  
  $messageMe = $maildata["message"];
  $messageThem = 'Hi! Thanks for the enquiry. We will respond as soon as we can!';
  
  $headersMe = 'From: ' . $me . "\n" .
      'Reply-To: ' . $them . "\n" .
      'X-Mailer: PHP/' . phpversion();

  $headersThem = 'From: ' . $me . "\n" .
      'Reply-To: ' . $me . "\n" .
      'X-Mailer: PHP/' . phpversion();

  mail($me, $subjectMe, $messageMe, $headersMe);

  mail($them, $subjectThem, $messageThem, $headersThem);

  respond($maildata);

}

function respond($maildata){

  $return = $_POST;

  $return["success"] = "true";
  
  $return["json"] = json_encode($maildata);

  echo json_encode($return);

}

?>