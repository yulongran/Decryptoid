<?php

function establishMySQLConnection(){
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die(sqlError());
  return $conn;
}


function closeMySQLConnection($conn){
   $conn->close();
}

/**
 * Display error message when mysql throw an error
 */
function sqlError()
{
    echo <<< _END
    We're sorry.
    We are unable to complete your request at this time. Please try again or come back later.
_END;
}

function registerationFailure(){
  http_response_code(400);
  echo json_encode(array("message" => "Fail to register, try a combination of username and password"));
}

/**
 * Sanitize html input
 */
function sanitizeString($var)
{
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

/**
 * Sanitize mysql input
 */
function sanitizeMySQL($conn, $var)
{
    $var = $conn->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}

/**
 * Generate random salt
 */
function generateRandomSalt()
{
    $library = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%^&*()!';
    return substr(str_shuffle($library), 0, 10);
}

/**
 * Hash Password
 */
function hashPassword($pw, $salt)
{
    return hash('ripemd128', $salt . $pw);
}
