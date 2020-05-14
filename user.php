<?php

require_once 'utlity.php';

function authentication($username, $password)
{
    $conn = establishMySQLConnection();
    $un = sanitizeMySQL($conn, $username);
    $pw = sanitizeMySQL($conn, $password);
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
            closeMySQLConnection($conn);
            return true;
        }
        // Wrong Password
        else {
            closeMySQLConnection($conn);
            return false;
        }
    }
    // User does not exist
    else {
        closeMySQLConnection($conn);
        return false;
    }
    closeMySQLConnection($conn);
    return false;
}

function registeration($username, $password)
{
    $conn = establishMySQLConnection();
    $un = sanitizeMySQL($conn, $username);
    $pw = sanitizeMySQL($conn, $password);
    $salt = generateRandomSalt();
    $token = hash('ripemd128', $salt . $pw);
    $stmt = $conn->prepare('INSERT INTO user VALUES (NULL, ?, ?, ?);');
    $stmt->bind_param('sss', $un, $token, $salt);
    if ($stmt->execute()) {
        closeMySQLConnection($conn);
        return true;
    } else {
        closeMySQLConnection($conn);
        die();
    }
}
