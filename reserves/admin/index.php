<!doctype html>
<html>
  <head>
    <title>Login to Add Reserves</title>
    <style type="text/css">
      @import "../js/dojo/resources/dojo.css";
      @import "../style.css";
    </style>
  </head>
  <body>
    <div id="login-container">
      <div id="login-title-image">
        <img src="../laurentian.jpg" />
      </div>
      <div id="login-welcome">
        <h1>Login to administer reserve list</h1>
        <p>Please log in using the username and password provided to you to administer the reserve list</p>
      </div>
      <div id="login-form">
        <form method="post" action="index.php">
          <table>
            <tr>
              <td><label for="username">Username:</label></td>
              <td><input type="text" name="username"></td>
            </tr>
            <tr>
              <td><label for="password">Password:</label></td>
              <td><input type="password" name="password"></td>
            </tr>
          </table>
          <input type="submit" name="submit" value="Login">
        </form>
      </div>
    </div>
  </body>
</html>

<?php

  //Login script

  $error = "<div id=\"error\"><p>Invalid Username or password</p></div>";

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // We aren't going to allow non alphanumeric usernames
    if (!ereg("^[A-Za-z0-9]", $_POST['username']))
      die($error);

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    require('users.php');
    // Check whether the username exists and if the password is correct
    if (array_key_exists($username, $users)) {
      if ($password == $users[$username]) {
        session_start();
        //Store a session var for the user, redirect to admin page
        $_SESSION['activeuser'] = md5($username.$password.$salt);
        header("Location: addreserves.php");
      }
      else {
        die($error);
      }
    }
    else {
      die($error);
    }
  }
?>
