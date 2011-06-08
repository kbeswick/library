<?php

$users = array(
  //define your users and md5'd passwords here
  "Reserve_user" => "md5d_password"
);

$salt = substr(md5(date("l")), 8);

?>
