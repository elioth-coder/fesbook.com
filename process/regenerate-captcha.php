<?php
require_once 'MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

require_once '../utils/simple-php-captcha/simple-php-captcha.php'; 
$_SESSION['captcha'] = simple_php_captcha();

echo json_encode([
  'status'=> 'success',
  'image_src' => $_SESSION['captcha']['image_src']
]);
?>