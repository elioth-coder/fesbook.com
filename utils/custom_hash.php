<?php
function custom_hash($str) {
  $salt = "WOXVENHITTY";
  $md5  = md5($str . $salt);
  $sha1 = sha1($salt . $md5);
  $hash = md5($md5 . $sha1);

  for($i=0; $i<strlen($str) + 8; $i++) {
    $hash = md5($hash) . sha1($hash);
  }

  $hash = strtoupper(md5($hash));

  return $hash;
}
?>