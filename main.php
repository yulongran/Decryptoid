<?php

require_once 'utility.php';

session_start();
if(isset($_SESSION['username'])){
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
              <h1> Main Content </h1>
          </div>
        </body>
      </html>
  _END;

}
else{
  redirect("authentication.php");
}
