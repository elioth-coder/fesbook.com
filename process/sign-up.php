<?php
require_once 'MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

if(!(isset($_SESSION['captcha']['code']) && $_SESSION['captcha']['code'] == $_POST['captcha'])) {
  $response = array(
    "message" => "Incorrect captcha.",
    "status" => "error"
  ); 
  
  echo json_encode($response);
  die();
}

if((isset($_POST['first_name']) && trim($_POST['first_name']) != '')
  && (isset($_POST['last_name']) && trim($_POST['last_name']) != '')
  && (isset($_POST['birthdate']) && trim($_POST['birthdate']) != '')
  && (isset($_POST['gender']) && trim($_POST['gender']) != '')
  && (isset($_POST['email']) && trim($_POST['email']) != '')
  && (isset($_POST['password']) && trim($_POST['password']) != '')
) {

  $fileUpload; 
  if($_FILES["file"]["error"] != 4) {
    require_once 'upload_image.php';

    $fileUpload = upload($_FILES['file'], '../uploads/');

    if($fileUpload['status'] == 'error') {
      echo json_encode($fileUpload);
      die();
    }
  } else {
    $fileUpload = array(
      "message" => "Empty file.",
      "status" => "error",
      "img" => NULL,
    );
  }

  try {
    require_once 'connection.php';

    // prepare and bind
    $stmt = $pdo->prepare("INSERT INTO user (first_name, last_name, birthdate, gender, email, password, avatar) 
    VALUES (:first_name, :last_name, :birthdate, :gender, :email, :password, :avatar)");
    $stmt->bindParam(':first_name', $first_name);   
    $stmt->bindParam(':last_name', $last_name);   
    $stmt->bindParam(':birthdate', $birthdate);   
    $stmt->bindParam(':gender', $gender);   
    $stmt->bindParam(':email', $email);   
    $stmt->bindParam(':password', $password);   
    $stmt->bindParam(':avatar', $avatar);   
  
    // set parameters and execute
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $avatar = ($fileUpload['status'] == 'error') ? "./assets/account.png" : "./uploads/" . $fileUpload['img'];
    $stmt->execute();
  
    $response = array(
      "message" => "Successfully signed up. You can now login using this account.",
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