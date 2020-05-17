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

/**
 * Register user
 * @param $conn MySQL connection
 * @param $un username
 * @param $pw password
 * @param $em email
 */
function register($conn, $un, $pw, $em)
{
    $un = sanitizeMySQL($conn, $un);
    $pw = sanitizeMySQL($conn, $pw);
    $em = sanitizeMySQL($conn, $em);
    $salt = generateRandomSalt();
    $hashedPW = hashPassword($pw, $salt);
    $stmt = $conn->prepare('INSERT INTO user VALUES (NULL, ?, ?, ? , ?)');
    $stmt->bind_param('ssss', $un, $em, $hashedPW, $salt);
    if (!$stmt->execute()) {
        sendAlert("Fail to create new account, try with another combination");
    } else {
        sendAlert("Successfully create your account");
    }
    $stmt->close();
    $conn->close();
}

/**
 * Authenticate user
 * @param $conn MySQL connection
 * @param $un sanitized username
 * @param $pw sanitized password
 */
function authentication($conn, $un, $pw)
{
    $un = sanitizeMySQL($conn, $un);
    $pw = sanitizeMySQL($conn, $pw);
    $stmt = $conn->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->bind_param('s', $un);
    $stmt->execute();
    $result = $stmt->get_result();
    // SQL Connection Error
    if (!$result) {
        die(sqlError());
    } elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $salt = $row['salt'];
        $token = hash('ripemd128', $salt . $pw);
        // Valid Credential
        if ($token === $row['password']) {
            session_start();
            $_SESSION['username'] = $un;
            $_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] .$_SERVER['HTTP_USER_AGENT']);
            $stmt->close();
            $conn->close();
            die(redirect("main.php"));
        }
        // Wrong Password
        else {
            sendAlert("Invalid combination of username and password");
        }
    }
    $stmt->close();
    $conn->close();
}

/**
 * Store user action
 * @param $conn MySQL connection
 * @param $username sanitized username
 * @param $input sanitized username input for cipher
 * @param $cipher santized cipher used for encryption or decryption
 */
function storeUserRecord($conn, $username, $input, $cipher)
{
    $username = sanitizeMySQL($conn, $username);
    $input = sanitizeMySQL($conn, $input);
    $cipher = sanitizeMySQL($conn, $cipher);
    $stmt = $conn->prepare('INSERT INTO history VALUES (NULL, ?, ?, ? , NOW())');
    $stmt->bind_param('sss', $username, $input, $cipher);
    $stmt->execute();
    $stmt->close();
}


function sendAlert($message)
{
    echo '<script language="javascript">';
    echo "alert('{$message}')";
    echo '</script>';
}

/**
 * Validation on username
 * @param $un sanitized username
 */
function validUsername($un)
{
    if (!preg_match("/[^0-9a-zA-Z_-]+/", $un)) {
        return true;
    }
    return false;
}

/**
 * Validation on user email
 * @param $em sanitized email address
 */
function validEmail($em)
{
    if (preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $em)) {
        return true;
    }
    return false;
}

function redirect($url)
{
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
