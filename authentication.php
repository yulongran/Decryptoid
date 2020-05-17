<?php

require_once 'login.php';
require_once 'utility.php';
require_once 'authenticationHTML.php';

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

displayAuthenticationForm();
