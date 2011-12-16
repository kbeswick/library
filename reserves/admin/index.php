<!doctype html>
<?php
/*
 * Copyright (C) 2011 Laurentian University
 * Kevin Beswick <kx_beswick@laurentian.ca> 
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, 
 *    this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright 
 *    notice, this list of conditions and the following disclaimer in the 
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote 
 *    products derived from this software without specific prior 
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS 
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR 
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE 
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT 
 * OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF 
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT 
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
 * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF 
 * SUCH DAMAGE.
 */
?>
<?php
  include('../header.php');
?>
    <div id="login-container">
    <h2 class="login_title">Login to administer reserve list</h2>
      <div id="login-form" class="light">
      <div id="login-welcome">
        <p>Please log in using the username and password provided to you to administer the reserve list</p>
      </div>
        <form method="post" action="index.php">
          <table>
            <tr>
              <td class="center"><label for="username">Username:</label></td>
              <td class="center"><input type="text" name="username"></td>
            </tr>
            <tr>
              <td class="center"><label for="password">Password:</label></td>
              <td class="center"><input type="password" name="password"></td>
            </tr>
          </table>
          <input type="submit" name="submit" value="Login">
        </form>
      </div>
<?php
  include('../footer.php');
?>
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
