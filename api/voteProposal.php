<?php
  include_once('proposals.php');
  $body = file_get_contents('php://input');

  if (isset($body)) {
      $json = json_decode($body);
      if (voteProposal($json->id)){
        $message = array('success' => 'Proposal was successfully created');
      } else {
        $message = array('error' => 'Proposal was not created');
      }
  } else {
      $message = array('error' => 'Inexistent request');
  }
  $JSONresponse = json_encode($message);
  echo $JSONresponse;
?>
