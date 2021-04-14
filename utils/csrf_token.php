<?php
function csrf_token() {
  $string="ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz0123456789";
  $shuffled = str_shuffle($string);
  $token= substr($shuffled,0,32);

  return $token;
}
?>