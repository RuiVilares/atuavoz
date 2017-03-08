<?php
  include_once('proposals.php');
  $body = file_get_contents('php://input');

  if (isset($body)) {
      $json = json_decode($body);
      if (rejectProposal($json->id)){
        $message = array('success' => 'Proposal was successfully removed');
      } else {
        $message = array('error' => 'Proposal was not removed');
      }
  } else {
      $message = array('error' => 'Inexistent request');
  }
  $JSONresponse = json_encode($message);
  echo $JSONresponse;
?>
