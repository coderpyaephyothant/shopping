
<?php
session_start();
require 'config/config.php';
require 'config/common.php';

if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>alert('please login first.');window.location.href='login.php'</script>";
}
if($_SESSION['role'] != 1 ){
  echo "<script>alert('Must be Admin Account..');window.location.href='login.php'</script>";
}

if(!empty($_POST)){
  $name = $_POST['name'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $image = $_FILES['image']['name'];
  $id = $_POST['id'];

if ( empty($_POST['name']) || empty($_POST['category']) ||  empty($_POST['description']) || empty($_POST['price'])
    || empty($_POST['quantity']) || (!empty($_POST['price']) && (is_numeric($_POST['price']) != 1 ))
    || (!empty($_POST['quantity']) && (is_numeric($_POST['quantity']) != 1) )){

  if (empty($_POST['name'])){
    $nameError = 'Please fill category name';
  }

  if(empty($_POST['description'])){
    $descriptionError = 'Please fill description ';
  }

  if(empty($_POST['category'])){
    $dropdownError = 'Please fill category ';
  }

  if(empty($_POST['price'])){
    $priceError = 'Please fill product prices. . . ';
  }

  if( !empty($_POST['price']) && (is_numeric($_POST['price'])!= 1) ){
    $priceError = 'Product price must be number. . . ';
  }

  if(empty($_POST['quantity'])){
    $quantityError = 'Please fill product quantity';
  }

  if(!empty($_POST['quantity']) && (is_numeric($_POST['quantity'])!= 1)   ){
    $quantityError = 'Product quantity must be number. . . .';
  }

}
else {


  $target_file = 'images/'.($_FILES['image']['name']);
  $file_type = pathinfo($target_file,PATHINFO_EXTENSION);

  if (!empty($image)){

    if ($file_type !='jpg' && $file_type != 'png' && $file_type != 'jpeg') {
      echo"<script>alert('Product Image File must be PNG/JPG or JPEG');</script>";
    }else{
      move_uploaded_file($_FILES['image']['tmp_name'],$target_file);
      $pdo_insert_data = $pdo->prepare( " UPDATE products SET name=:name,description=:description,price=:price,category_id=:category_id,quantity=:quantity,image=:image
       WHERE id='$id' " );
      $result_insert_data = $pdo_insert_data->execute(
         array(
           ':name'=>$name,':description'=>$description,':price'=>$price,':category_id'=>$category,':quantity'=>$quantity,':image'=>$image
         )
       );
    }
  }else{
    $pdo_insert_data = $pdo->prepare( " UPDATE products SET name=:name,description=:description,price=:price,category_id=:category_id,quantity=:quantity
     WHERE id='$id' " );
     $result_insert_data = $pdo_insert_data->execute(
       array(
         ':name'=>$name,':description'=>$description,':price'=>$price,':category_id'=>$category,':quantity'=>$quantity
       )
     );
  }

    if ($result_insert_data) {
      echo"<script>alert('Successfully Updated...');window.location.href='index.php';</script>";
    }
  }
}


$pdo_statement1 = $pdo->prepare(" SELECT * FROM products WHERE id=".$_GET['id']);
$pdo_statement1->execute();
$data_ById = $pdo_statement1->fetchAll();
// print"<pre>";
// print_r($data_ById );
 ?>

 <?php
 include('header.php');
  ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                      <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $data_ById[0]['id'] ?>">
                        <label for="Name">Name</label>
                        <p style="color:red;"><?php echo empty($nameError) ? '': $nameError ?></p>
                        <input class="form-control" type="text" name="name" value="<?php echo $data_ById[0]['name'] ?>">
                        </div>

                        <div class="form-group">
                          <label for="Description">Description</label>
                          <p style="color:red;"><?php echo empty($descriptionError) ? '': $descriptionError ?></p>
                          <textarea class="form-control" name="description" rows="8" cols="80"><?php echo $data_ById[0]['description'] ?></textarea>
                          </div>

                        <div class="form-group">
                          <?php
                          $pdo_categories  = $pdo->prepare(" SELECT * FROM categories ");
                          $pdo_categories->execute();
                          $result_categories = $pdo_categories->fetchAll();
                          // print"<pre>";
                          // print_r($result_categories);
                           ?>
                          <label for="category">Category</label>
                          <p style="color:red;"><?php echo empty($dropdownError) ? '': $dropdownError ?></p>
                          <select class="form-control" name="category">
                            <option value=""> - -SELECT- -  </option>
                            <?php foreach ($result_categories as $value): ?>
                            <?php if ($value['id'] == $data_ById[0]['category_id']):?>
                              <option value="<?php echo $value['id'] ?>" selected><?php echo $value['name'] ?></option>
                            <?php else : ?>
                              <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                            <?php endif ?>
                            <?php endforeach; ?>
                          </select>
                          </div>

                        <div class="form-group">
                          <label for="price">Price</label>
                          <p style="color:red;"><?php echo empty($priceError) ? '': $priceError ?></p>
                          <input class="form-control" type="number" name="price" value="<?php echo $data_ById[0]['price'] ?>">
                          </div>

                          <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <p style="color:red;"><?php echo empty($quantityError) ? '': $quantityError ?></p>
                            <input class="form-control" type="number" name="quantity" value="<?php echo $data_ById[0]['quantity'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label> <br> <br>
                                <img class="" src="images/<?php echo $data_ById[0]['image'] ?>" alt="" width="400px"> <br> <br>
                                <input  type="file" name="image"  >
                            </div> <br>

                          <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="title" value="Upadate Now"> &nbsp; &nbsp;
                            <a href="index.php" class="btn btn-info">Back</a>
                            </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <?php
  include('footer.html');
   ?>
