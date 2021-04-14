<?php
require_once 'MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  $response = array(
    "message" => "Error: You are not logged in.",
    "status" => "error"
  );

  echo json_encode($response);
  die();
}

// Validates if the form has a valid csrf_token if not kill script.
if(!isset($_SESSION['csrf_token']) || ($_SESSION['csrf_token'] != $_POST['csrf_token'])) {
  $response = array(
    "message" => "Error: Invalid csrf token.",
    "status" => "error"
  );

  echo json_encode($response);
  die();
}

require_once 'User.php';

$user = unserialize($_SESSION['user']);

if(isset($_POST['content']) && trim($_POST['content']) != '') {
  try {
    require_once 'connection.php';

    // prepare and bind
    $stmt = $pdo->prepare("INSERT INTO post (content, user_id) 
    VALUES (:content, :user_id)");
    $stmt->bindParam(':content', $content);   
    $stmt->bindParam(':user_id', $user_id);   
  
    // set parameters and execute
    $content = htmlentities($_POST['content']); // Counter for XSS Attacks
    $user_id = $user->id;
    $stmt->execute();

    $response = array(
      "message" => "Successfully created a post.",
      "status" => "success"
    );      
  
  } catch(PDOException $e) {
    $response = array(
      "message" => "Error: " . $e->getMessage(),
      "status" => "error"
    );
  }
} else {
  $response = array(
    "message" => "Error: Fill up all the required fields.",
    "status" => "error"
  );
}

echo json_encode($response);
?>