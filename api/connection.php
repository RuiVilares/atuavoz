<?php
  $username = 'sql11161978';
  $password = 'SxDEVjkUjW';
  $host = 'sql11.freemysqlhosting.net';
  $dbname = 'sql11161978';
  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
  try {
      $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
      die("Failed to connect to the database: ".$ex->getMessage());
  }
?>
