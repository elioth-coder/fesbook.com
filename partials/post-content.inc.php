<div class="w-full rounded-xl my-10 border-gray-400 border-2 bg-white">
  <div class="p-5 flex">
    <img class="w-16 h-16 rounded-full border-gray-900 border-2" src="<?php echo $row['avatar']; ?>" />
    <h1 class="text-gray-600 text-2xl capitalize font-bold align-middle ml-3 mt-3"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h1>
  </div>
  <div class="p-5 border-gray-100 border-t-2 border-b-2 text-lg">
    <?php echo $row['content']; ?>
  </div>
  <div class="p-5 text-right">
    <h3 class="text-lg text-gray-500">Posted last: <span><?php echo $row['datetime']; ?></span></h3>
  </div>
</div>