<?php
// set page headers
$page_title = "Produto";
include_once "header.php";
  
// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Visualizar Produtos";
    echo "</a>";
echo "</div>";
// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  

include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/category.php';

$database = new Database();
$db = $database->getConnection();
  

$product = new Product($db);
$category = new Category($db);
  

$product->id = $id;
  
$product->readOne();
?>
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Nome</td>
        <td><?=$product->name?></td>
    </tr>
    <tr>
        <td>Preço</td>
        <td><?=$product->price?></td>
    </tr>
    <tr>
        <td>Descrição</td>
        <td><?=$product->description?>
    </tr>
    <tr>
        <td>Categoria</td>
        <td><?php $category->id=$product->category_id;$category->readName();echo $category->name;?></td>
    </tr>
</table>

<?php include_once "footer.php";
?>