<?php
require_once 'db_credentials.php';

// Create connection
try {
  $pdo = new PDO("mysql:host=".HOST_NAME.";dbname=".DATABASENAME, USERNAME, PASSWORD);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  throw $e;
}
?>