<?php
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

function register($conn, $un, $pw, $em){
  $salt = generateRandomSalt();
  $hashedPW = hashPassword($pw, $salt);
  $stmt = $conn->prepare('INSERT INTO user VALUES (NULL, ?, ?, ? , ?)');
  $stmt->bind_param('ssss', $un, $em, $hashedPW, $salt);
  if(!$stmt->execute()){
    sendAlert("Fail to create new account, try with another combination");
  }
  else{
    sendAlert("Successfully create your account");
  }
  $stmt->close();
  $conn->close();
}

function authentication($conn, $un, $pw){
    $stmt = $conn->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->bind_param('s', $un);
    $stmt->execute();
    $result = $stmt->get_result();
    // SQL Connection Error
    if (!$result) die(sqlError());
    else if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $salt = $row['salt'];
        $token = hash('ripemd128', $salt . $pw);
        // Valid Credential
        if ($token === $row['password']) {
            session_start();
            $_SESSION['username'] = $un;
            $stmt->close();
            $conn->close();
            die (redirect("main.php"));
        }
        // Wrong Password
        else {
            sendAlert("Invalid combination of username and password");
        }
    }
    $stmt->close();
    $conn->close();
    sendAlert("Invalid combination of username and password");
}

function sendAlert($message){
  echo '<script language="javascript">';
  echo "alert('{$message}')";
  echo '</script>';
}

function validUsername($un){
  if (!preg_match("/[^0-9a-zA-Z_-]+/", $un)){
    return true;
  }
  return false;
}

function validEmail($em){
  if(preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $em)){
    return true;
  }
  return false;
}

function redirect($url){
  header("Location: {$url}");
  die();
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
