<?php
  try {
      $db = new PDO('sqlite:D:\wamp64\www\atuavoz\database\mysql.db');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
      die("Failed to connect to the database: ".$ex->getMessage());
  }
?>
