<?php

require_once 'login.php';
require_once 'utility.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die(sqlError());
}

session_start();
if (isset($_SESSION['username'])) {
    $un = sanitizeMySQL($conn, $_SESSION['username']);
    $stmt = $conn->prepare('SELECT * FROM history WHERE username = ?');
    $stmt->bind_param('s', $un);
    $stmt->execute();
    $tableContent = "";
    $result = $stmt->get_result();
    while($row = $result->fetch_array()){
      $tableContent = $tableContent ."<tr>".
      "<td>".$row['username']."</td>".
      "<td>".$row['input']."</td>".
      "<td>".$row['cipher']."</td>".
      "<td>".$row['time']."</td>".
      "</tr>";
    }
    echo
      <<<_END
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8" />
          <title>Decryption</title>
          <link rel="stylesheet" href="./history.css" />
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
                    <a class="nav-link" href="/main.php">Decrypt</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/history.php">History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/project">Log Out</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-container">
              <h1>Cipher Text History</h1>
              <table>
                <tr>
                  <th>Username</th>
                  <th>Input</th>
                  <th>Cipher</th>
                  <th>Timestamp</th>
                </tr>
                {$tableContent}
              </table>
            </div>
          </div>
        </body>
      </html>

  _END;
} else {
    redirect("authentication.php");
}
