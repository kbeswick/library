<?php
  session_start();
  if (!isset($_SESSION['activeuser'])) {
    header("Location: index.php");
  }
  else {
    require('users.php');

    foreach($users as $username => $password) {
      if (md5($username.$password.$salt) == $_SESSION['activeuser'])
        return;
    }

    header("Location: index.php");
  }
?>
