<?php
  include_once('connection.php');

  date_default_timezone_set('UTC');

  function createProposal($author, $title, $description) {
      global $db;
      $validation = 0;
      $nVotes = 0;
      $stmt = $db->prepare('INSERT INTO Proposals (author, title, description, validation, nVotes) VALUES (:author, :title, :description, :validation, :nVotes)');
      $stmt->bindParam(':author', $author, PDO::PARAM_STR);
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':validation', $validation, PDO::PARAM_INT);
      $stmt->bindParam(':nVotes', $nVotes, PDO::PARAM_INT);
      try {
          $stmt->execute();
          return true;
      } catch (PDOException $e) {
          return false;
      }
  }

  function getAcceptedProposals() {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Proposals WHERE validation ORDER BY nVotes DESC');
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

  function getWaitingProposals() {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Proposals WHERE not validation');
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

  function acceptProposal($id) {
    global $db;
    $stmt = $db->prepare('UPDATE Proposals SET validation = 1 WHERE Proposals.id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
  }

  function rejectProposal($id) {
    global $db;
    $stmt = $db->prepare('DELETE FROM Proposals WHERE id=:id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
  }

  function voteProposal($id) {
    global $db;

    $stmt = $db->prepare('SELECT nVotes FROM Proposals WHERE Proposals.id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (PDOException $e) {
        return false;
    }

    $nVotes = $result["nVotes"]+1;
    $stmt = $db->prepare('UPDATE Proposals SET nVotes = :nVotes WHERE Proposals.id = :id');
    $stmt->bindParam(':nVotes', $nVotes, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
  }

?>
