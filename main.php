<?php

require_once 'login.php';
require_once 'utility.php';
require_once 'cipher.php';

$translate = "";

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die(sqlError());


session_start();
if(isset($_SESSION['username'])){
  if (isset($_POST["input"]) && isset($_POST["key"])) {
    if(!empty($_POST["input"]) && !empty($_POST["key"])){
      $input = sanitizeMySQL($conn, $_POST["input"]);
      $selection = sanitizeMySQL($conn, $_POST["function-selection"]);
      if($selection ===  'decrypt'){
          $translate = simpleSubstitutionEncryption($input);
      }
      else{
          $translate = simpleSubstitutionDecryption($input);
      }
      $conn->close();
    }
  }
  echo
      <<<_END
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8" />
          <title>Decryption</title>
          <link rel="stylesheet" href="./main.css" />
        </head>
        <body>
          <div class="main-container">
            <div class="nav-container">
              <div class="name">
                <a class="nav-link" href="/main.php">Decryptoid</a>
              </div>
              <div class="navs">
                <ul class="nav justify-content-center">
                  <li class="nav-item">
                    <a class="nav-link" href="#app-about">Decrypt</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/about">History</a>
                  </li>
                  <li class="Înav-item">
                    <a class="nav-link" href="/experience">About</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/project">Log Out</a>
                  </li>
                </ul>
              </div>
            </div>
            <form
              class="register-form"
              method="post"
              action="main.php"
              enctype="multipart/form-data"
            >
              <div class="card-container">
                <h1>Cipher Text Tool</h1>
                <textarea
                  cols="30"
                  rows="5"
                  placeholder="Enter your text"
                  name="input"
                ></textarea>
                <input
                  type="text"
                  name="key"
                  placeholder="Enter your encryption/decryption key"
                />
                <div class="encrypt-decrypt-seletion">
                  <label>Choose to decrypt or encrypt your text:</label>
                  <select name="function-selection">
                    <option value="decrypt">Encrypt</option>
                    <option value="encrypt">Decrypt</option>
                  </select>
                </div>
                <div class="result-text">
                  <h3>Transformed text</h3>
                  <p>{$translate}</p>
                </div>
                <button type="submit" class="login-btn">CALCULATE</button>
              </div>
            </form>
          </div>
        </body>
      </html>
  _END;
}
else{
  redirect("authentication.php");
}
