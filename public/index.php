<?php

require_once '../helpers/login.php';
require_once '../helpers/utility.php';
require_once '../helpers/cipher.php';
require_once '../helpers/session.php';

$translate = "";
$displayLoggedin = "";
$displayLoggedOut = "display:none";
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die(sqlError());
}

session_start();
sessionFixation();

if (isset($_SESSION['username'])) {
    $displayLoggedin = "display: none";
    $displayLoggedOut = "";
}
if (isset($_POST["input"]) || isset($_FILES['fileInput'])) {
    $input = "";
    if (!empty($_POST["input"])) {
        $input = sanitizeMySQL($conn, $_POST["input"]);
    } else {
        $type = htmlentities($_FILES["fileInput"]["type"]);
        if ($type === 'text/plain') {
            $input = file_get_contents(sanitizeMySQL($conn, $_FILES["fileInput"]["tmp_name"]));
        } else {
            sendAlert("Invalid file format");
        }
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
    // User Logged in
    if (isset($_SESSION['username'])) {
        storeUserRecord($conn, sanitizeMySQL($conn, $_SESSION["username"]), $input, $cipher);
    }
    $conn->close();
}
    echo
      <<<_END
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8" />
          <title>Decryption</title>
          <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous"
          />
          <link rel="stylesheet" href="../css/index.css" />
        </head>
        <body>
          <div class="d-flex flex-column min-vh-100">
            <nav class="navbar px-5">
              <a class="navbar-brand" href="index.php">Decryptoid</a>
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link active" href="index.php">Cipher</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="history.php">History</a>
                </li>
                <li class="nav-item" style="{$displayLoggedin}">
                  <a class="nav-link" href="authentication.php">Log in</a>
                </li>
                <li class="nav-item" style="{$displayLoggedOut}">
                  <a class="nav-link" href="logout.php" tabindex="-1" aria-disabled="true"
                    >Log out</a
                  >
                </li>
              </ul>
            </nav>
            <div class="card flex-grow-1 align-self-center">
              <div class="card-body">
                <p class="h1 mb-4">Cipher Tool</p>
                <form
                  class="form d-flex flex-column justify-content-center"
                  method="post"
                  action="../public/index.php"
                  enctype="multipart/form-data"
                >
                  <div class="form-group">
                    <textarea
                      class="form-control"
                      placeholder="Enter your text"
                      name="input"
                    ></textarea>
                  </div>
                  <div class="input-group mb-3">
                    <div class="custom-file">
                      <input
                        type="file"
                        class="custom-file-input"
                        name="fileInput"
                        id="inputGroupFile01"
                        aria-describedby="inputGroupFileAddon01"
                      />
                      <label class="custom-file-label" for="inputGroupFile01"
                        >Choose a text file</label
                      >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label"
                      >Choose to encrypt or decrypt</label
                    >
                    <select class="form-control col-sm-5" name="function-selection">
                      <option value="encrypt">Encrypt</option>
                      <option value="decrypt">Decrypt</option>
                    </select>
                  </div>
                  <div class="form-group row ">
                    <label class="col-sm-3 col-form-label"
                      >Choose cipher algorithm</label
                    >
                    <select class="form-control col-sm-5" name="cipher-selection">
                      <option value="simple-substitution">Simple Substitution</option>
                      <option value="double-transposition"
                        >Double Transposition</option
                      >
                      <option value="rc4">RC4</option>
                    </select>
                  </div>
                  <div class="transformed-text">
                    <h3>Transformed text</h3>
                    <p>{$translate}</p>
                  </div>
                  <button type="submit" class="login-btn">CALCULATE</button>
                </form>
              </div>
            </div>
          </div>
        </body>
      </html>
  _END;
