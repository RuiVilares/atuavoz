<?php
  $username = getenv("SHAREUP_USER");
  $password = getenv("SHAREUP_PASS");
  $host = "db.fe.up.pt";
  $dbname = 'shareup';
  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
  try {
      $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
      die("Failed to connect to the database: ".$ex->getMessage());
  }
?>
