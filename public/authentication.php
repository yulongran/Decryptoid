<?php

require_once 'login.php';
require_once 'utility.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die(sqlError());
}


if (isset($_POST["username"]) && isset($_POST["password"]) &&
    !empty($_POST["username"]) && !empty($_POST["password"])) {
    $un = sanitizeMySQL($conn, $_POST["username"]);
    $pw = sanitizeMySQL($conn, $_POST["password"]);
    authentication($conn, $un, $pw);
}


echo
<<<_END
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Decryption</title>
    <link rel="stylesheet" href="./authentication.css" />
  </head>
  <body>
    <div class="container">
      <div class="login-wrapper">
        <h2>Welcome</h2>
        <form class="login-form" method="post" action="authentication.php" enctype="multipart/form-data">
          <div class="input-wrapper">
            <label>Username</label>
            <input type="text" name="username" />
          </div>
          <div class="input-wrapper">
            <label>Password</label>
            <input type="password" name="password" />
          </div>
          <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="create-accont-container">
          <span>
            Don’t have an account?
          </span>
          <a href="registeration.php">
            Sign Up
          </a>
        </div>
      </div>
    </div>
  </body>
</html>
_END;
