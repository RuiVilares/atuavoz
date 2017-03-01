<?php
  include_once('connection.php');

  date_default_timezone_set('UTC');

  function createProposal($author, $title, $description) {
      global $db;
      $stmt = $db->prepare('INSERT INTO Proposals (author, title, description, date, validation, nVotes) VALUES (:author, :title, :description, :date, :validation, :nVotes)');
      $stmt->bindParam(':author', $author, PDO::PARAM_STR);
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':date', date(), PDO::PARAM_STR);
      $stmt->bindParam(':validation', 'False', PDO::PARAM_STR);
      $stmt->bindParam(':nVotes', 0, PDO::PARAM_INT);
      try {
          $stmt->execute();
      } catch (PDOException $e) {
          return $e->getMessage();
      }
  }

?>
