<?php

$users = array(
  //define your users and md5'd passwords here
  "reserve" => md5("password")
);

$salt = substr(md5(date("l")), 8);

?>
