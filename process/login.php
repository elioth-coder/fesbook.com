<?php
require_once 'MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

if((isset($_POST['email']) && trim($_POST['email']) != '')
  && (isset($_POST['password']) && trim($_POST['password']) != '')
) {

  define('TIME_TO_WAIT', 10);
  if(!isset($_SESSION['attempt'])) {
    $_SESSION['attempt'] = 0;
  }

  if(isset($_SESSION['time']) && ($_SESSION['attempt'] >= 3)) {
    $remaining_time = ($_SESSION['time'] + TIME_TO_WAIT) - time();

    if($remaining_time < 1) { // if user already waited 60 seconds or depending on the value of TIME_TO_WAIT
      unset($_SESSION['time']);
      $_SESSION['attempt'] = 0;
    }
  }

  if($_SESSION['attempt'] >= 3) {
    $_SESSION['time'] = time();

    $response = array(
      "message" => "Too many attempts. Try again after " . TIME_TO_WAIT . " seconds.",
      "status" => "error"
    ); 
    echo json_encode($response);
    die();
  }

  try {
    require_once 'connection.php';
    require_once 'User.php';
    require_once '../utils/custom_hash.php';

    // prepare and bind
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email=:email AND password=:password LIMIT 1");
    $stmt->execute([
      "email" => $_POST['email'],
      "password" => custom_hash($_POST['password'])
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$result) {
      $response = array(
        "message" => "Invalid username or password.",
        "status" => "error"
      ); 
      $_SESSION['attempt'] += 1;

      echo json_encode($response);
      die();
    }

    $_SESSION['attempt'] = 0;
    $user = new User();

    $user->id = $result['id'];
    $user->first_name = $result['first_name'];
    $user->last_name = $result['last_name'];
    $user->birthdate = $result['birthdate'];
    $user->gender = $result['gender'];
    $user->email = $result['email'];
    $user->avatar = $result['avatar'];

    session_regenerate_id(); //Changes PHPSESSID's value to counter session hijacking.
    $_SESSION['user'] = serialize($user);
    $_SESSION['logged_in'] = true;

    $response = array(
      "message" => "Successfully logged in.",
      "status" => "success"
    );  
  } catch(Exception $e) {
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