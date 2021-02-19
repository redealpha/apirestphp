<?php   
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/product.php';
    include_once '../objects/category.php';
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // pass connection to objects
    $product = new Product($db);
    $category = new Category($db);


    $page_title = "Adicionar Produto";
    include "header.php";

    echo "<div class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Read Products</a>
    </div>";


    if($_POST){
        $product->name = $_POST['name'];
        $product->price = $_POST['price'];
        $product->description = $_POST['description'];
        $product->category_id = $_POST['category_id'];

        if($product->create()){
            echo "<div class='alert alert-success'>Produto adicionado com sucesso.</div>";
        }else{
            echo '<div class="alert alert-danger">Erro ao adicionar o produto.</div>';
        }
    }
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
  <table class='table table-hover table-responsive table-bordered'>

      <tr>
          <td>Nome</td>
          <td><input type='text' name='name' class='form-control' /></td>
      </tr>

      <tr>
          <td>Preço</td>
          <td><input type='text' name='price' class='form-control' /></td>
      </tr>

      <tr>
          <td>Descrição</td>
          <td><textarea name='description' class='form-control'></textarea></td>
      </tr>

      <tr>
          <td>Categoria</td>
          <td>
          <?php
                // read the product categories from the database
                $stmt = $category->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id'>";
                    echo "<option>Select category...</option>";
                
                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row_category);
                        echo "<option value='{$id}'>{$name}</option>";
                    }
                
                echo "</select>";
            ?>
          </td>
      </tr>

      <tr>
          <td></td>
          <td>
              <button type="submit" class="btn btn-primary">Adicionar Produto</button>
          </td>
      </tr>

  </table>
</form>
<?php

    include 'footer.php';

?>