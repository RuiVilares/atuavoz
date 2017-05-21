<?php
  include_once('connection.php');

  date_default_timezone_set('UTC');
  define('COOKIE_VALIDITY', 86400);

  function createProposal($author, $title, $description) {
      global $db;
      $validation = 0;
      $nVotes = 0;
      $stmt = $db->prepare('INSERT INTO Proposals (title, author, description, validation, nVotes) VALUES (:title, :author, :description, :validation, :nVotes)');
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
        $proposals = [];
        # Add a flag to each proposal, with a boolean indicating wether the user already voted
        foreach ($result as $proposal) {
            $proposal['canVote'] = userCanVote($proposal['id']);
            $proposals[] = $proposal;
        }
        $res = array();
        $res["proposals"] = $proposals;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return $res;
  }

  function getBestProposals() {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Proposals WHERE validation AND nVotes > 0 ORDER BY nVotes DESC LIMIT 2');
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

    if (!$result) {
        # No proposal was found
        return false;
    }

    $nVotes = $result["nVotes"]+1;
    $stmt = $db->prepare('UPDATE Proposals SET nVotes = :nVotes WHERE Proposals.id = :id');
    $stmt->bindParam(':nVotes', $nVotes, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        # Create a cookie indicating that the user voted for this proposal
        setcookie(getCookieName($id), time(), time() + COOKIE_VALIDITY, '/');
        return true;
    } catch (PDOException $e) {
        return false;
    }
  }

  function login($username, $password) {
    global $db;

    $stmt = $db->prepare('SELECT * FROM Admins WHERE Admins.username = :username AND Admins.password = :password');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    } catch (PDOException $e) {
        return false;
    }
  }

  /**
   * Finds out if the user has voted
   * @param $proposalID
   * @return boolean
   */
  function userCanVote($proposalID)
  {
    if (!isset($_COOKIE[getCookieName($proposalID)])) {
        # There isn't a cookie for this proposal
        return true;
    }
    # There is a cookie, check the val
    $val = $_COOKIE[getCookieName($proposalID)];
    if (($val + COOKIE_VALIDITY) > time()) {
        # Cookie is less than a day old
        return false;
    }
    return true;
  }

/**
 * Common access point to get the name of a cookie
 * @param $id
 * @return string
 */
  function getCookieName($id)
  {
      return 'Proposal' . $id;
  }

?>
