<?php
  try {
      $db = new PDO('sqlite:./database/mysql.db');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
      die("Failed to connect to the database: ".$ex->getMessage());
  }
?>
