<?php

require_once 'login.php';
require_once 'utility.php';
require_once 'cipher.php';
require_once 'session.php';

$translate = "";
$loggedin = "inline";
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die(sqlError());
}

session_start();
sessionFixation();
if (isset($_SESSION['username'])) {
    $loggedin = "none";

    if (isset($_POST["input"]) || isset($_FILES['fileInput'])) {
        $input = "";
        if (!empty($_POST["input"])) {
            $input = sanitizeMySQL($conn, $_POST["input"]);
        } else {
            $input = file_get_contents(sanitizeMySQL($conn, $_FILES["fileInput"]["tmp_name"]));

        }
        $selection = sanitizeMySQL($conn, $_POST["function-selection"]);
        $cipher = sanitizeMySQL($conn, $_POST["cipher-selection"]);
        if ($cipher === "simple-substitution") {
            $translate =  $selection === 'encrypt' ? simpleSubstitutionEncryption($input) : simpleSubstitutionDecryption($input);
        } elseif ($cipher === "double-transposition") {
            $translate =  $selection === 'encrypt' ? doubleTranspositionEncryption($input) : doubleTranspositionDecryption($input);
        } elseif ($cipher === "rc4") {
            $translate =  $selection === 'encrypt' ? utf8_encode(rc4EncryptionDecryption($input)) : utf8_decode(rc4EncryptionDecryption($input));
        }
        storeUserRecord($conn, sanitizeMySQL($conn, $_SESSION["username"]), $input, $cipher);
        $conn->close();
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
                    <a class="nav-link" href="/main.php">Cipher Tool</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/history.php">History</a>
                  </li>
                  <li style="display:{$loggedin}" class="nav-item">
                    <a class="nav-link" href="/authentication.php">Log in</a>
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
                <div class="encrypt-decrypt-seletion">
                  <label>Enter your text or upload a text file:</label>
                  <input type="file" name="fileInput" id="fileToUpload">
                </div>
                <div class="encrypt-decrypt-seletion">
                  <label>Choose to decrypt or encrypt your text:</label>
                  <select name="function-selection">
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                  </select>
                </div>
                <div class="encrypt-decrypt-seletion">
                  <label>Choose cipher:</label>
                  <select name="cipher-selection">
                    <option value="simple-substitution">Simple Substitution</option>
                    <option value="double-transposition">Double Transposition</option>
                    <option value="rc4">RC4</option>
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
