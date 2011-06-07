<!doctype html>
<html>
  <head>
    <title>Login to Add Reserves</title>
  </head>
  <body>
    <form method="post" action="index.php">
      <table>
        <tr>
          <td>Username:</td>
          <td><input type="text" name="username"></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input type="password" name="password"></td>
        </tr>
      </table>
      <input type="submit" name="submit" value="Login">
    </form>
  </body>
</html>

<?php

  //Login script

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // We aren't going to allow non alphanumeric usernames
    if (!ereg("^[A-Za-z0-9]", $_POST['username']))
      die("Invalid Username or password");

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
        die("Invalid Username or password");
      }
    }
    else {
      die("Invalid Username or password");
    }
  }
?>
