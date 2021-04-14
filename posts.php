<?php
require_once 'process/MySQLSessionHandler.php';
(new MySQLSessionHandler())->session_start();

if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header('Location: ./');
  die();  
}
require_once 'process/User.php';

$user = unserialize($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fesbook | Posts</title>
  <link rel="stylesheet" href="./css/tailwind.css">
</head>
<body class="bg-gray-100">
  <div class="px-5 py-8 bg-blue-400">
    <h1 class="text-3xl text-center text-white font-bold">fesbook.com</h1>
  </div>
  <div class="container mx-auto">
    <div class="flex">
      <div class="w-full">
        <div class="p-10 pb-0">
          <h1 class="float-left text-3xl text-gray-600 font-bold">
            <img class="inline w-16 h-16 rounded-full border-gray-900 border-2" src="<?php echo $user->avatar; ?>" />
            <span class="text-gray-600"><?php echo $user->email; ?></span>
          </h1>
          <button onclick="logoutAllSession();" class="ml-1 hover:border-blue-500 hover:bg-blue-400 hover:text-white float-right rounded-xl border-gray-600 border-2 px-5 py-2">Logout All Session</button>
          <button onclick="logout();" class="hover:border-blue-500 hover:bg-blue-400 hover:text-white float-right rounded-xl border-gray-600 border-2 px-5 py-2">Logout</button>
          <br class="clear-both">
        </div>
        <div class="p-10">
          <?php 
            require_once 'utils/csrf_token.php';
            $_SESSION['csrf_token'] = csrf_token();
            include_once 'partials/post-form.inc.php'; 
          ?>
        </div>
        <div class="p-10 pt-0">
          <h1 class="text-3xl text-gray-600 font-bold">Posts</h1>
          <?php
            try {
              require_once 'process/connection.php';

              // prepare and bind
              $stmt = $pdo->prepare("
                SELECT `user`.`first_name` AS `first_name`,
                  `user`.`last_name` AS `last_name`,
                  `user`.`avatar` AS `avatar`,
                  `post`.`content` AS `content`,
                  `post`.`datetime` AS `datetime`
                FROM `post` 
                INNER JOIN `user` ON 
                `post`.`user_id`=`user`.`id`
                ORDER BY `post`.`datetime` DESC
              ");
              $stmt->execute();

              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                include 'partials/post-content.inc.php';
              }
            } catch(PDOException $e) {
              print $e->getMessage();
            }
          ?>
        </div>
      </div>
    </div>
  </div>
  <script>
    async function logoutAllSession() {
      let response = await fetch('./process/logout_all_session.php', {
        credentials: "same-origin",
        method: 'GET',
      });
      let { message, status} = await response.json();
      
      if(status == 'success') {
        alert(message);
        window.location.reload();
      } else {
        alert(message);
      }
    };

    async function logout() {
      let response = await fetch('./process/logout.php', {
        credentials: "same-origin",
        method: 'GET',
      });
      let { message, status} = await response.json();
      
      if(status == 'success') {
        window.location = './';
      } else {
        alert(message);
      }
    };

    postForm.onsubmit = async (e) => {
      e.preventDefault();

      let response = await fetch('./process/post.php', {
        credentials: "same-origin",
        method: 'POST',
        body: new FormData(postForm)
      });
      let { message, status} = await response.json();
          
      if(status == 'success') {
        alert(message);
        window.location = './';
      } else {
        alert(message);
      }
    };

  </script>
</body>
</html>