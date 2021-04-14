<?php
require_once 'MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

try {
  require_once 'connection.php';
  require_once 'User.php';

  $user = unserialize($_SESSION['user']);
  $session_data = '';
  $email_data = 's:5:"email";s:' . strlen($user->email) . ':' . '"' . $user->email . '"';
  // prepare and bind
  $stmt = $pdo->prepare("UPDATE sessions SET session_data=:session_data WHERE session_data LIKE CONCAT('%', :email_data, '%')");
  $stmt->execute([
    "session_data" => $session_data,
    "email_data" => $email_data,
  ]);
  unset($_SESSION["user"]);
  unset($_SESSION["logged_in"]);

  $response = array(
    "message" => "Successfully logged out all session.",
    "status" => "success"
  );  
} catch(Exception $e) {
  $response = array(
    "message" => "Error: " . $e->getMessage(),
    "status" => "error"
  );
}

echo json_encode($response);
?>