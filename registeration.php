<?php

require_once 'login.php';
require_once 'utility.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die(sqlError());


if (isset($_POST["username"]) && isset($_POST["password"])) {
  if(!empty($_POST["username"]) && !empty($_POST["password"])){
    $un = sanitizeMySQL($conn, $_POST["username"]);
    $pw = sanitizeMySQL($conn, $_POST["password"]);
    register($conn,$un, $pw);
  }
}
echo
    <<<_END
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8" />
        <title>Decryption</title>
        <link rel="stylesheet" href="./registeration.css" />
      </head>
      <body>
        <div class="container">
          <div class="register-wrapper">
            <h2>User Registeration</h2>
            <form class="register-form" method="post" action="registeration.php" enctype="multipart/form-data">
              <div class="input-wrapper">
                <label>Username</label>
                <input type="text" name="username" />
              </div>
              <div class="input-wrapper">
                <label>Password</label>
                <input type="password" name="password" />
              </div>
              <div class="input-wrapper">
                <label>Verify Password</label>
                <input type="password" name="verifyPassword" />
              </div>
              <button type="submit" class="login-btn">Sign up</button>
            </form>
            <div class="create-accont-container">
              <span>
                Already have an account?
              </span>
              <a href="authentication.php">
                Sign in
              </a>
            </div>
          </div>
        </div>
      </body>
    </html>
_END;
