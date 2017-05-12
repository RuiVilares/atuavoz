<?php
  include_once('proposals.php');
  $body = file_get_contents('php://input');
  if (isset($body)) {
      $json = json_decode($body);
      if (userCanVote($json->id)) {
          if (voteProposal($json->id)) {
              $message = ['success' => 'Proposal was successfully voted on'];
          } else {
              $message = ['error' => 'Proposal was not voted on'];
          }
      } else {
          $message = ['error' => 'You can\'t vote for this proposal'];
      }
  } else {
      $message = array('error' => 'Inexistent request');
  }
  $JSONresponse = json_encode($message);
  echo $JSONresponse;
?>
