<?php

function displayAuthenticationForm()
{
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
}
