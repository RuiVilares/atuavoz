<?php
  session_start();
  include_once 'connection.php';
  include_once('proposals.php');
  $body = file_get_contents('php://input');

  if (isset($body)) {
      $json = json_decode($body);
      $result = login($json->username, $json->password);
      if (isset($result) && !empty($result)) {
        $_SESSION['username'] = $result['username'];
        $message = array('success' => 'You have been successfully logged in');
      } else {
        $message = array('error' => 'An error has occurred');
      }
  } else {
      $message = array('error' => 'Inexistent request');
  }
  $JSONresponse = json_encode($message);
  echo $JSONresponse;
?>
