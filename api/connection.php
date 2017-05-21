<?php

  $username = 'b8c1e5be7ccd6d';
  $password = 'a63ee240';
  $host = 'eu-cdbr-west-01.cleardb.com';
  $dbname = 'heroku_0e318643a0823d9';
  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
  
  try {
      $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
      die("Failed to connect to the database: ".$ex->getMessage());
  }
?>
