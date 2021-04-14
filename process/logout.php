<?php
require_once 'MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

unset($_SESSION["user"]);
unset($_SESSION["logged_in"]);

echo json_encode(array(
  "message" => "Successfully logged out.",
  "status" => "success"
));
?>