<?php
require_once 'user.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = $data->password;

if(empty($username) || empty($password)){
  http_response_code(400);
  echo json_encode(array("message" => "Fail to register, try a combination of username and password"));
}
registeration($username, $password);
