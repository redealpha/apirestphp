<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../objects/product.php";
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;

$secret_key = "AUTOREDE";
$jwt = null;
$database = new Database();
$db = $database->getConnection();

$authHeader =  $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);
$jwt = $arr[1];

if($jwt){
    try{
        $decoded = JWT::decode($jwt, $secret_key, array("HS256"));
        $product = new Product($db);

        $stmt = $product->read();
        $num = $stmt->rowCount();

        if($num>0){
            $products_arr = array();
            $products_arr['records'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $product_item = array(
                    'id'   => $id,
                    'name' => $name,
                    'description' => html_entity_decode($description),
                    'price' => $price,
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                );
                array_push($products_arr['records'],$product_item);
            }
            http_response_code(200);
            echo json_encode($products_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message"=>"0 produtos encontrados."));
        }
    }catch(Exception $e){
        http_response_code(401);
        echo json_encode(array(
            "message" => "Acesso negado",
            "error" => $e->getMessage()
        ));
    }
}
