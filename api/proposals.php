<?php
  include_once('connection.php');

  date_default_timezone_set('UTC');

  function createProposal($author, $title, $description) {
      global $db;
      $date = strtotime (date ("Y-m-d H:i:s"));
      $validation = 0;
      $nVotes = 0;
      $stmt = $db->prepare('INSERT INTO Proposals (author, title, description, date, validation, nVotes) VALUES (:author, :title, :description, :date, :validation, :nVotes)');
      $stmt->bindParam(':author', $author, PDO::PARAM_STR);
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':date', $date, PDO::PARAM_STR);
      $stmt->bindParam(':validation', $validation, PDO::PARAM_BOOL);
      $stmt->bindParam(':nVotes', $nVotes, PDO::PARAM_INT);
      try {
          if(!$stmt->execute()) echo $stmt->error;
      } catch (PDOException $e) {
          return $e->getMessage();
      }
  }

  function getAcceptedProposal() {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Proposals ORDER BY nVotes DESC');
    try {
        $stmt->execute();
        $result = $stmt->fetchAll();
        $res = array();
        $res["proposals"] = $result;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return $res;
}

?>
