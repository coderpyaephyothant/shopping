
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


if ( empty($_POST['name']) || empty($_POST['category']) ||  empty($_POST['description']) || empty($_POST['price'])|| empty($_POST['quantity']) || empty($_FILES['image']['name'])
|| (!empty($_POST['price']) && (is_numeric($_POST['price']) != 1 ))
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

  if(empty($_FILES['image']['name'])){
    $imageError = 'Please insert product images. . . ';
  }
}
else {

  $target_file = 'images/'.($_FILES['image']['name']);
  $file_type = pathinfo($target_file,PATHINFO_EXTENSION);
  if ($file_type !='jpg' && $file_type != 'png' && $file_type != 'jpeg') {
    echo"<script>alert('Product Image File must be PNG/JPG or JPEG');</script>";
  }else{

    // echo $_POST['category'];
    //
    // echo $_FILES['image']['name'];exit();

    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],$target_file);

    $pdo_insert_data = $pdo->prepare( " INSERT INTO products (name,description,price,category_id,quantity,image)
     VALUES (:name,:description,:price,:category_id,:quantity,:image) " );
    $result_insert_data = $pdo_insert_data->execute(
      array(
        ':name'=>$name,':description'=>$description,':price'=>$price,':category_id'=>$category,':quantity'=>$quantity,':image'=>$image
      )
    );
    // print"<pre>";
    // print_r($result_insert_data );
    if ($result_insert_data) {
      echo"<script>alert('Successfully Created...');window.location.href='index.php';</script>";
    }
  }
}

}
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
                <form class="" action="product_create.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                      <div class="form-group">
                        <label for="Name">Name</label>
                        <p style="color:red;"><?php echo empty($nameError) ? '': $nameError ?></p>
                        <input class="form-control" type="text" name="name" value="">
                        </div>

                        <div class="form-group">
                          <label for="Description">Description</label>
                          <p style="color:red;"><?php echo empty($descriptionError) ? '': $descriptionError ?></p>
                          <textarea class="form-control" name="description" rows="8" cols="80"></textarea>
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
                              <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                            <?php endforeach; ?>
                          </select>
                          </div>

                        <div class="form-group">
                          <label for="price">Price</label>
                          <p style="color:red;"><?php echo empty($priceError) ? '': $priceError ?></p>
                          <input class="form-control" type="number" name="price" >
                          </div>

                          <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <p style="color:red;"><?php echo empty($quantityError) ? '': $quantityError ?></p>
                            <input class="form-control" type="number" name="quantity" >
                            </div>

                            <div class="form-group">
                              <label for="image">Image</label>
                              <p style="color:red;"><?php echo empty($imageError) ? '': $imageError ?></p>
                              <input  type="file" name="image" value="">
                            </div> <br>

                          <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="title" value="Submit"> &nbsp; &nbsp;
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
