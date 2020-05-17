<?php

require_once 'login.php';
require_once 'utility.php';
require_once 'registerationHTML.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die(sqlError());


if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
  if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"])){
    $un = sanitizeMySQL($conn, $_POST["username"]);
    $pw = sanitizeMySQL($conn, $_POST["password"]);
    $em = sanitizeMySQL($conn, $_POST["email"]);
    if (validUsername($un) && validEmail($em)){
      register($conn,$un, $pw, $em);
    }
    else{
      sendAlert("Invalid username or email format");
    }
  }
}

displayRegisterationForm();
