<?php

include_once "../config/database.php";
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$secret_key = "AUTOREDE";
$jwt = null;
$database = new Database();
$conn = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));


$authHeader =  $_SERVER['HTTP_AUTHORIZATION'];

$arr = explode(" ", $authHeader);

$jwt = $arr[1];

if($jwt){
    try{
        $decoded = JWT::decode($jwt, $secret_key, array("HS256"));

        echo json_encode(array(
            "message" => "Acesso Garantido",
            "error" => ""
        ));
    }catch(Exception $e){
        http_response_code(401);
        echo json_encode(array(
            "message" => "Acesso negado",
            "error" => $e->getMessage()
        ));
    }
}