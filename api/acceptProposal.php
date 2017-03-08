<?php
  include_once('proposals.php');
  $body = file_get_contents('php://input');

  if (isset($body)) {
      $json = json_decode($body);
      if (acceptProposal($json->id)){
        $message = array('success' => 'Proposal was successfully accepted');
      } else {
        $message = array('error' => 'Proposal was not accepted');
      }
  } else {
      $message = array('error' => 'Inexistent request');
  }
  $JSONresponse = json_encode($message);
  echo $JSONresponse;
?>
