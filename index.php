<?php 
require_once 'process/MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
  header('Location: posts.php');
  die();
}

require_once 'utils/simple-php-captcha/simple-php-captcha.php'; 
$_SESSION['captcha'] = simple_php_captcha();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fesbook | Login or Sign Up</title>
  <link rel="stylesheet" href="./css/tailwind.css">
</head>
<body>
  <div class="px-5 py-8 bg-blue-400">
    <h1 class="text-3xl text-center text-white font-bold">fesbook.com</h1>
  </div>
  <div class="container mx-auto">
    <div class="flex text-center">
      <div class="hidden lg:w-1/2 lg:block">
        <div style="height: 576px;" class="flex w-full relative p-16">
          <img src="./assets/connected.jpg" class="m-auto" />
        </div>
      </div>
      <div class="lg:w-1/2 w-full p-12">
        <button onclick="activatePanel('login');" id="login-btn" class="panel-btn font-bold text-xl px-10 p-5">Login</button>
        <button onclick="activatePanel('sign-up');" id="sign-up-btn" class="panel-btn font-bold text-xl p-5 mb-5">Sign Up</button>
        <div id="login-pane" class="panel-pane hidden">
          <?php include './partials/login-form.inc.php'; ?>
        </div>
        <div id="sign-up-pane" class="panel-pane hidden">
          <?php include './partials/sign-up-form.inc.php'; ?>
        </div>
      </div>
    </div>
  </div>
  <script src="./js/activate-panel.js"></script>
  <script src="./js/submit-form.js?version=6"></script>
  <script>
    activatePanel('login');
  </script>
</body>
</html>