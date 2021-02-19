<?php

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/category.php';

$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$category = new Category($db);
  
$page_title = "Todos Produtos Adicionados";
include_once "header.php";
  

$stmt = $product->readAll($from_record_num, $records_per_page);
  
$page_url = "index.php?";
  
$total_rows=$product->countAll();
  

include_once "read_template.php";
  

include_once "footer.php";
?>